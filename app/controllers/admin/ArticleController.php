<?php

namespace app\controllers\admin;

use app\controllers\ApiController;
use app\utils\Helper;
use Faker\Factory;

class ArticleController extends ApiController
{
    private $faker;
    public function __construct($app)
    {
        parent::__construct($app);
        $this->faker = Factory::create('en_US');
    }


    public function index()
    {
        $queryParams = $this->app->request()->query;
        $perPage = $queryParams['per_page'] ?? 10;
        $page = $queryParams['page'] ?? 1;
        // 模拟状态筛选（该参数起作用）
        $status = $queryParams['status'] ?? null;
        if ($status !== null && !in_array($status, ['draft', 'published', 'archived'])) {
            $this->return400(null, 'Bad request!');
            return;
        }
        // 模拟搜索关键词（该参数不起作用）
        $keyword = $queryParams['keyword'] ?? null;

        // 模拟分类筛选（该参数起作用）
        $categoryId = $queryParams['category_id'] ?? null;
        if ($categoryId !== null && !in_array($categoryId, array_keys($this->getStaticCategories()))) {
            $this->return400(null, 'Bad request!');
            return;
        }
        $mockTotal = 86;
        $mockArticles = [];
        for ($i = 0; $i < $perPage; $i++) {
            $mockArticles[] = $this->generateMockArticle($status, $categoryId, $keyword);
        }
        $this->return200([
            'total' => $mockTotal,
            'per_page' => $perPage,
            'current_page' => $page,
            'items' => $mockArticles,
        ]);
    }

    private function getStaticCategories(): array
    {
        return [
            1 => [
                "id" => 1,
                "name" => "default"
            ],
            2 => [
                "id" => 2,
                "name" => "life"
            ],
            3 => [
                "id" => 3,
                "name" => "work"
            ],
        ];
    }


    private function generateMockArticle(?string $status = null, ?int $categoryId = null, ?string $keyword = null): array
    {
        $status = $status ?? Helper::oneOf(['draft', 'published', 'archived']);
        $categories = $this->getStaticCategories();
        $categoryId = $categoryId ?? Helper::oneOf([1, 2, 3]);
        return [
            'id' => $this->faker->numberBetween(1, 1000),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(3),
            'excerpt' => $this->faker->sentence(3),
            "category_id" => $categoryId,
            "category" => $categories[$categoryId],
            "status" => $status,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d H:i:s'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            'published_at' => $status !== 'draft' ? $this->faker->dateTimeBetween('-15 days', 'now')->format('Y-m-d H:i:s') : null,
        ];
    }
}