<?php

namespace app\controllers\admin;

use app\controllers\ApiController;
use Faker\Factory;

class CategoryController extends ApiController
{
    private $faker;


    public function __construct($app)
    {
        parent::__construct($app);
        $this->faker = Factory::create('en_US');
    }

    private function getStaticFullCategories(): array
    {
        return [
            1 => [
                "id" => 1,
                "name" => "default",
                "description" => "Default category",
                "slug" => "default",
                "created_at" => "2023-08-21 12:31:45",
                "updated_at" => "2023-08-21 12:31:45",
                "articles_count" => $this->faker->numberBetween(0, 100),
            ],
            2 => [
                "id" => 2,
                "name" => "life",
                "description" => "Some memory in life",
                "slug" => "life",
                "created_at" => "2024-09-01 09:25:13",
                "updated_at" => "2024-09-16 13:23:17",
                "articles_count" => $this->faker->numberBetween(0, 100),
            ],
            3 => [
                "id" => 3,
                "name" => "work",
                "description" => "Something related to work",
                "slug" => "work",
                "created_at" => "2025-12-24 17:30:09",
                "updated_at" => "2025-12-24 17:30:09",
                "articles_count" => $this->faker->numberBetween(0, 100),
            ],
        ];
    }

    public function all()
    {
        $categories = $this->getStaticFullCategories();
        $this->return200(array_values($categories));
    }

    public function show(int $id)
    {
        $categories = $this->getStaticFullCategories();
        if (!isset($categories[$id])) {
            $this->return404('Category not found!');
            return;
        }
        $this->return200($categories[$id]);
    }

    public function store()
    {
        // Get JSON input
        $data = $this->app->request()->data;
        // 这里我们初步校验 name 和 description 是否为空
        if (empty($data['name']) || empty($data['description']) || empty($data['slug'])) {
            $this->return422(null, 'name, description and slug are required!');
            return;
        }
        $this->return201(array_merge((array)$data, [
            'id' => 4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'articles_count' => 0,
        ]));
    }

    public function update(int $id)
    {
        // Get JSON input
        $data = $this->app->request()->data;
        // 这里我们初步校验 name 和 description 是否为空
        if (empty($data['name']) || empty($data['description']) || empty($data['slug'])) {
            $this->return422(null, 'name, description and slug are required!');
            return;
        }
        $this->return200(array_merge((array)$data, [
            'id' => $id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]));
    }

    public function destroy(int $id)
    {
        $this->return200(true);
    }

}