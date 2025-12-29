<?php

namespace app\utils;

class CorsUtil
{
    public function setUp(): void
    {
        $request = \Flight::request();
        $response = \Flight::response();

        // Allow from any origin
        if ($request->getVar('HTTP_ORIGIN') !== '') {
            // $this->allowOrigins();
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Max-Age', '1728000');
        }
        $response->header('Access-Control-Allow-Origin', '*');
        if (strtoupper($request->method) === 'OPTIONS') {
            if ($request->getVar('HTTP_ACCESS_CONTROL_REQUEST_METHOD') !== '') {
                $response->header(
                    'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS, HEAD'
                );
            }
            if ($request->getVar('HTTP_ACCESS_CONTROL_REQUEST_HEADERS') !== '') {
                $response->header(
                    "Access-Control-Allow-Headers",
                    $request->getVar('HTTP_ACCESS_CONTROL_REQUEST_HEADERS')
                );
            }
            $response->status(204);
            $response->send();
            exit;
        }
    }

    private function allowOrigins(): void
    {
        $allowed = [
            'http://localhost:5173',
            'http://localhost:5174',
        ];

        $request = \Flight::request();
        /*
        if (in_array($request->getVar('HTTP_ORIGIN'), $allowed, true) === true) {
            $response = \Flight::response();
            $response->header('Access-Control-Allow-Origin', $request->getVar('HTTP_ORIGIN'));
        }
        */
        $response->header('Access-Control-Allow-Origin', $request->getVar('HTTP_ORIGIN'));
    }
}