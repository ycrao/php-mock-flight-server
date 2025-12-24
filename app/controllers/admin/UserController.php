<?php

namespace app\controllers\admin;

use app\controllers\ApiController;
use app\models\MockUser;

class UserController extends ApiController
{
    public function index()
    {
        $queryParams = $this->app->request()->query;
        $perPage = $queryParams['per_page'] ?? 10;
        $page = $queryParams['page'] ?? 1;
        // 理论上也是接受这些参数的，但是这里不实现
        $this->return200([
            'total' => 2,
            'per_page' => $perPage,
            'current_page' => $page,
            'items' => array_values($this->getStaticUsers()),
        ]);
    }

    private function getStaticUsers()
    {
        $user1 = new MockUser();
        $user1->init(1, 'Admin', 'admin@example.com', 'admin123');

        $user2 = new MockUser();
        $user2->init(2, 'Demo', 'demo@foxmail.com', 'demo123456');

        return [
            1 => array_merge($user1->toArray(), ['role' => 'administrator']),
            2 => array_merge($user2->toArray(), ['role' => 'demo']),
        ];
    }

    public function me()
    {
        $user = $this->app->get('user');
        $userData = $user->toArray();
        $userData['avatar'] = 'https://avatars.githubusercontent.com/u/3280204?v=4&size=80';
        $userData['role'] = 'administrator';
        $userData['user_id'] = $userData['id'];
        unset($userData['id']);
        $this->return200($userData);
    }

    public function store()
    {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (!isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
            $this->return400('Bad request!');
            return;
        }

        $name = $input['name'];
        $email = $input['email'];
        $password = $input['password'];

        $mockUser = new MockUser();
        $mockUser->init(3, $name, $email, $password);

        $this->return201($mockUser->toArray());
    }

    public function update($id)
    {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (!isset($input['name']) || !isset($input['email'])) {
            $this->return400('Bad request!');
            return;
        }

        $name = $input['name'];
        $email = $input['email'];

        $mockUsers = $this->getStaticUsers();
        if (!isset($mockUsers[$id])) {
            $this->return404('User not found!');
            return;
        }
        $mockUser = $mockUsers[$id];
        $mockUser['name'] = $name;
        $mockUser['email'] = $email;

        $this->return200($mockUser);
    }

    public function show($id)
    {
        $mockUsers = $this->getStaticUsers();
        if (!isset($mockUsers[$id])) {
            $this->return404('User not found!');
            return;
        }
        $mockUser = $mockUsers[$id];
        $this->return200($mockUser);
    }

    public function destroy($id)
    {
        if ($id == 1) {
            $this->return400('Can not delete admin user!');
            return;
        }
        $this->return200(true);
    }
}