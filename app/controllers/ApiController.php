<?php

namespace app\controllers;

use flight\Engine;

class ApiController
{
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
	}


    public function respJson($data, $code = 200, $message = 'ok')
    {
        if ($code < 200 || $code >= 600) {
            $code = 500;
        }
        $this->app->response()->status($code);
        $this->app->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function return200($data = null, $message = 'ok')
    {
        $this->respJson($data, 200, $message);
    }

    public function return400($data = null, $message = 'bad request!')
    {
        $this->respJson($data, 400, $message);
    }

    public function return401($data = null, $message = 'unauthorized!')
    {
        $this->respJson($data, 401, $message);
    }

    public function return403($data = null, $message = 'forbidden!')
    {
        $this->respJson($data, 403, $message);
    }

    public function return422($data = null, $message = 'unprocessable entity!')
    {
        $this->respJson($data, 422, $message);
    }
}