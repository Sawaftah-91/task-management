<?php
namespace App\Controllers;
use App\Models\TaskModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TaskController extends ResourceController {
    private function getUserIDFromJWT() {
        $key = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $this->failUnauthorized('Token not provided or malformed');
        }
        $token = $matches[1];
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded->uid;
        }
        catch(\Exception $e) {
            return $this->failUnauthorized('Invalid Token');
        }
    }
    public function create() {
        $taskModel = new TaskModel();
        // Validate incoming data
        $rules = ['title' => 'required|min_length[3]', 'description' => 'required|min_length[5]', 'status' => 'required|in_list[pending,completed]', 'due_date' => 'required|valid_date[Y-m-d]'];
        $data = $this->request->getJSON(true);
        print_r($data);
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $data['user_id'] = $this->getUserIDFromJWT();
        $taskModel->insert($data);
        return $this->respondCreated(['message' => 'Task created successfully']);
    }
    public function index() {
        $taskModel = new TaskModel();
        $userId = $this->getUserIDFromJWT();
        $tasks = $taskModel->where('user_id', $userId)->findAll();
        return $this->respond($tasks);
    }
    public function show($id = null) {
        $taskModel = new TaskModel();
        $userId = $this->getUserIDFromJWT();
        $task = $taskModel->where(['id' => $id, 'user_id' => $userId])->first();
        if (!$task) {
            return $this->failNotFound('Task not found');
        }
        return $this->respond($task);
    }
    public function update($id = null) {
        $taskModel = new TaskModel();
        $userId = $this->getUserIDFromJWT();
        // Verify the task exists
        $task = $taskModel->where(['id' => $id, 'user_id' => $userId])->first();
        if (!$task) {
            return $this->failNotFound('Task not found');
        }
        // Get the data from the request
        $data = $this->request->getJSON(true);
        print_r($data);
        // Check if data is empty
        if (empty($data)) {
            return $this->failValidationErrors(['error' => 'No data provided for update']);
        }
        // Update the task
        if (!$taskModel->update($id, $data)) {
            return $this->failServerError('Failed to update task');
        }
        return $this->respond(['message' => 'Task updated successfully']);
    }
    public function delete($id = null) {
        $taskModel = new TaskModel();
        $userId = $this->getUserIDFromJWT();
        $task = $taskModel->where(['id' => $id, 'user_id' => $userId])->first();
        if (!$task) {
            return $this->failNotFound('Task not found');
        }
        $taskModel->delete($id);
        return $this->respondNoContent('Task deleted successfully');
    }
}
