<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $key = getenv('JWT_SECRET');
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')->setJSON(['message' => 'Unauthorized'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
        $token = $matches[1];
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        }
        catch(\Exception $e) {
            return service('response')->setJSON(['message' => 'Invalid Token'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
