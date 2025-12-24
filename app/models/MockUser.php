<?php

namespace app\models;

use app\utils\Helper;

class MockUser
{
    public int $id;
    protected string $password;

    public string $name;
    public string $email;

    public function init(int $id, string $name, string $email, string $password): MockUser
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->setPassword($password);
        return $this;
    }


    public function checkPassword(string $password): bool
    {
        return $this->password === md5($password);
    }

    public function setPassword(string $password): void
    {
        $this->password = md5($password);
    }
}