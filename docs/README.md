php-mock-flight-server
----------------------

>   基于 `flightphp` 框架实现的 `mock` 服务器 。


## 初始化

```bash
composer create-project flightphp/skeleton php-mock-flight-server
```

## 修改

- 在 `app/config/routes.php` 中注释掉测试路由，增加上 admin 相关路由。
- 在 `app/controllers/admin` 目录下新增 `AuthController.php` 文件，实现用户认证相关接口。
- 在 `app/controllers/admin` 目录下新增 `UserController.php` 文件，实现用户相关接口。
- 在 `app/controllers/admin` 目录下新增 `ArticleController.php` 文件，实现文章相关接口。
- 在 `app/controllers/admin` 目录下新增 `CategoryController.php` 文件，实现分类相关接口。
- 在 `app/middleware` 目录下新增 `AdminAuthMiddleware.php` 文件，实现认证中间件（认证 admin 后台用户）。
- 在 `app/models` 目录下新增 `MockUser` 模型（完全虚拟的，不与数据库交互），模拟用户 ORM 对象。
- 在 `app/utils` 目录下新增 `Helper.php` 文件，实现相关工具助手方法。


## 路由

具体，参考 `app/config/routes.php` 文件，这里只列出一些重要的路由。

```plaintext
- 登录 POST http://localhost:8000/admin-api/ms-user/auth/login
- 用户列表 GET http://localhost:8000/admin-api/ms-user/user
- 当前登录用户信息 GET http://localhost:8000/admin-api/ms-user/me
- 文章列表 GET http://localhost:8000/admin-api/ms-content/article
- 获取特定 id 文章 GET http://localhost:8000/admin-api/ms-content/article/{id}
- 所有分类 GET http://localhost:8000/admin-api/ms-content/category/all
```