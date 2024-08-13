<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthController extends ResourceController {
    public function register() {
        $userModel = new UserModel();
        $data = $this->request->getPost();
        if (empty($data['username']) || empty($data['password'])) {
            return $this->fail('Username and password are required');
        }
        if ($userModel->where('username', $data['username'])->first()) {
            return $this->fail('Username already exists');
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $userModel->insert($data);
        return $this->respondCreated(['message' => 'User registered successfully']);
    }
    public function login() {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);
        log_message('debug', 'Login attempt data: ' . print_r($data, true));
        if (empty($data['username']) || empty($data['password'])) {
            return $this->fail('Username and password are required');
        }
        $user = $userModel->where('username', $data['username'])->first();
        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->failUnauthorized('Invalid credentials');
        }
        $key = getenv('JWT_SECRET');
        echo 'JWT Secret: ' . $key;
        if (!$key) {
            return $this->fail('JWT_SECRET not set in environment');
        }
        $payload = ['iat' => time(), 'exp' => time() + 3600, // Token expires in 1 hour
        'uid' => $user['id']];
        $token = JWT::encode($payload, $key, 'HS256');
        return $this->respond(['token' => $token]);
    }
}
