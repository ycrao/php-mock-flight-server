<?php

namespace app\controllers\admin;

use app\controllers\ApiController;
use app\models\MockUser;
use app\utils\Helper;

class AuthController extends ApiController
{

    public function postLogin()
    {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (!isset($input['email']) || !isset($input['password'])) {
            $this->return400(null, 'Bad request!');
            return;
        }

        $email = $input['email'];
        $password = $input['password'];

        $mockUser = $this->generateMockUser();

        // Mock authentication - check for valid credentials
        if ($email === $mockUser->email && $mockUser->checkPassword($password)) {
            // Success response
            $this->return200([
                'access_token' => $this->generateToken(),
                'user_id' => $mockUser->id,
                'name' => $mockUser->name,
                'email' => Helper::hideEmail($mockUser->email),
                'role' => 'administrator',
                'avatar' => 'https://avatars.githubusercontent.com/u/3280204?v=4&size=80'
            ]);
        } else {
            // Invalid credentials
            $this->return422(null, 'incorrect email or password!');
        }
    }

    private function generateToken(): string
    {
        // Generate a UUID-like token for mock purposes
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function generateMockUser(): MockUser
    {
        $user = new MockUser();
        $user->id = 1;
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->setPassword('admin123');
        return $user;
    }
}