<?php

namespace app\middlewares;

use app\models\MockUser;
use app\utils\Helper;
use flight\Engine;

class AdminUserAuthMiddleware
{
    protected Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
	}

    public function before(array $params): void
    {
        // `Authorization: Bearer 27d997c3-c191-4475-9a5a-0306e924203f`
        $rawToken = $this->app->request()->header('Authorization');

        $token = str_replace('Bearer ', '', $rawToken);

        if (empty($token) || !Helper::isUuid($token)) {
            $this->app->halt(401, 'Unauthorized');
        }
        $user = new MockUser();
        $user->init(1, 'Admin', 'admin@example.com', 'admin123');
        $this->app->set('user', $user);
    }
}