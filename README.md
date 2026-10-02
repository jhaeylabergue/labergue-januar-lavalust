# LavaLust Framework

> A lightweight, fast PHP framework built for developers who want clean MVC architecture without unnecessary complexity or performance overhead.

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-8892BF)](https://www.php.net/)
[![GitHub Stars](https://img.shields.io/github/stars/ronmarasigan/lavalust?style=flat)](https://github.com/ronmarasigan/lavalust/stargazers)

---

## Overview

**LavaLust** is an open-source PHP framework that follows the **MVC (Model–View–Controller)** architectural pattern. It is designed for developers who need a structured, maintainable, and scalable foundation — without the bloat of heavier modern frameworks.

Whether you are building a simple web application, a REST API, or a teaching project, LavaLust provides the right tools with minimal friction.

---

## Features

| Feature | Description |
|---|---|
| **MVC Architecture** | Clean separation of Models, Views, and Controllers for organized, maintainable code |
| **Built-in Routing** | Flexible URL routing that maps requests to controllers with minimal configuration |
| **Libraries & Helpers** | Reusable components for sessions, forms, validation, and database access |
| **Modular Design** | Scalable structure that supports clean organization as your application grows |
| **REST API Support** | First-class support for building RESTful APIs using LavaLust conventions |
| **ORM-like Models** | Simplified, readable database interaction without a heavy abstraction layer |

---

## Requirements

- PHP 7.4 or higher
- A web server with URL rewriting support (Apache `.htaccess` or Nginx config)
- Composer (optional, for dependency management)

---

## Installation

**Clone the repository:**

```bash
git clone https://github.com/ronmarasigan/lavalust.git
cd lavalust
```

**Or download a release directly:**

```bash
wget https://github.com/ronmarasigan/lavalust/archive/refs/heads/main.zip
unzip main.zip
```

Configure your web server to point to the project root and ensure `mod_rewrite` (Apache) or equivalent is enabled.

---

## Quick Start

### 1. Define a Route

**File:** `app/config/routes.php`

```php
$router->get('/', 'Welcome::index');
$router->get('/about', 'Welcome::about');
$router->post('/users/store', 'Users::store');
```

### 2. Create a Controller

**File:** `app/controllers/Welcome.php`

```php
<?php

class Welcome extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';
        $this->call->view('welcome', $data);
    }

    public function about()
    {
        $this->call->view('about');
    }
}
```

### 3. Create a View

**File:** `app/views/welcome.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1>Welcome to LavaLust Framework</h1>
    <p>Lightweight. Fast. MVC.</p>
</body>
</html>
```

### 4. Create a Model

**File:** `app/models/User_model.php`

```php
<?php

class User_model extends Model
{
    protected $table = 'users';

    public function getAll()
    {
        return $this->db->table($this->table)->get()->getResult();
    }

    public function findById(int $id)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get()
    }
}
```

---

## Project Structure

```
lavalust/
├── app/
│   ├── config/          # Application configuration (database, routes, etc.)
│   ├── controllers/     # Controller classes
│   ├── models/          # Model classes
│   ├── views/           # View templates
│   └── libraries/       # Custom libraries and helpers
├── scheme/              # Core framework files (do not modify)
├── public/              # Publicly accessible entry point
│   └── index.php
└── runtime/            # Cache, logs, and uploads (must be writable)
```

---

## Configuration

### Database

**File:** `app/config/database.php`

```php
$database['main'] = array(
    'driver'	=> getenv('DB_DRIVER') ?: 'mysql',
    'hostname'	=> getenv('DB_HOST') ?: '',
    'port'		=> getenv('DB_PORT') ?: '',
    'username'	=> getenv('DB_USERNAME') ?: '',
    'password'	=> getenv('DB_PASSWORD') ?: '',
    'database'	=> getenv('DB_DATABASE') ?: '',
    'charset'	=> getenv('DB_CHARSET') ?: 'utf8mb4',
    'dbprefix'	=> '',
    'ssl_ca'    => getenv('DB_SSL_CA') ?: '',
    'ssl_verify'=> getenv('DB_SSL_VERIFY') === false
        ? true
        : filter_var(getenv('DB_SSL_VERIFY'), FILTER_VALIDATE_BOOLEAN),
    // Optional for SQLite
    'path'      => ''
);
```

### Base URL

**File:** `app/config/config.php`

```php
$config['base_url'] = 'http://localhost:3000/';
```

---

## Building a REST API

LavaLust supports REST API development out of the box. Controllers can return JSON responses for API endpoints.

```php
<?php

class Api extends Controller
{
    $this->call->library('api');

    public function users()
    {
        $this->api->require_method('GET');
        $auth = $this->api->require_jwt(); 

        $this->call->model('User_model');
        $users = $this->User_model->getAll();

        $this->api->respond(['data' => $users]);
    }
}
```

Route definition:

```php
$router->get('/api/users', 'Api::users');
```

---

## Philosophy

LavaLust is built on a single principle: **minimal core, maximum control.**

Modern frameworks often add layers of abstraction that benefit large enterprise teams but get in the way of developers who want to understand exactly what their code is doing. LavaLust provides structure and utilities without hiding the underlying logic — making it an excellent choice for:

- **Rapid prototyping** — Get an application running in minutes
- **Learning MVC** — Understand how each architectural layer works
- **Lightweight production apps** — Deploy without dragging in unused dependencies
- **Teaching PHP development** — Clear conventions, readable source code

---

## Documentation

Full documentation is available at **[https://lavalust.netlify.app](https://lavalust.netlify.app)**

Topics covered include:

- Installation and server configuration
- Routing: static, dynamic, and grouped routes
- Controllers and request handling
- Models and query builder
- Views, layouts, and partials
- Built-in libraries (sessions, form validation, file upload)
- Helper functions
- REST API development
- Security best practices

---

## Contributing

Contributions are welcome. To contribute:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m "Add your feature description"`
4. Push to your branch: `git push origin feature/your-feature-name`
5. Open a pull request against `main`

Please ensure your code follows the existing style conventions and includes relevant documentation or comments where appropriate.

---

## Roadmap

- [ ] CLI tool for generating controllers, models, and migrations
- [ ] Middleware support
- [ ] Improved query builder with relationship support
- [ ] Enhanced error handling and debugging tools

---

## Laboratory Exercise 6: Token API and Migrations

The API is served by LavaLust. The separate React/Vue frontend must call this
API over HTTP and must not connect to MySQL directly.

### Environment variables

Copy `.env.example` to `.env` locally, then replace its placeholders. Do not
commit `.env` or put database credentials in the frontend.

| Variable | Purpose |
|---|---|
| `APP_ENV` | `development` locally; use `production` on Render |
| `APP_KEY` | Long random key for LavaLust |
| `BASE_URL` | Local base URL or the deployed Render service URL |
| `ADMIN_EMAIL` | The only email permitted to sign in to product management |
| `ADMIN_SETUP_TOKEN` | One-time secret required to provision the admin account |
| `DB_DRIVER` | Set to `mysql` |
| `DB_HOST`, `DB_PORT` | Aiven MySQL host and port |
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Aiven database credentials |
| `DB_CHARSET` | Usually `utf8mb4` |
| `DB_SSL_CA` | Path to Aiven's public CA certificate, normally `app/certs/ca.pem` |
| `DB_SSL_VERIFY` | Set to `1` to verify the database certificate |
| `API_JWT_SECRET` | Random secret of at least 32 characters for access/refresh JWTs |
| `API_REFRESH_TOKEN_KEY` | Separate random secret of at least 32 characters |
| `FRONTEND_ORIGIN` | Exact frontend origin allowed by CORS, including scheme and port |

Use different generated random values for `APP_KEY`, `API_JWT_SECRET`, and
`API_REFRESH_TOKEN_KEY`, and `ADMIN_SETUP_TOKEN`. For example, generate secrets locally with
`php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"`.

### Run locally

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
# Edit .env with your local/development Aiven settings and generated keys.
php lava serve
```

In a separate terminal, create/update the database tables:

```sh
php lava migration run
```

Check migration status with `php lava migration status`. To create one, use
`php lava migration create-migration --name=create_orders_table`.

Migration `rollback-all` and `refresh` delete schema/data. Use them only on a
disposable development database, never on Aiven production.

### Deploy to Render

1. Create a Render Web Service from this repository and select Docker.
2. Add the environment variables above in Render's Environment settings. Set
   `BASE_URL` to the service URL, `APP_ENV=production`, and `FRONTEND_ORIGIN`
   to the deployed frontend's exact origin. Do not commit or copy `.env` into
   the image.
3. Add the Aiven host, port, database, username, password, and certificate
   path as Render environment values. `app/certs/ca.pem` is the public CA file
   included in this repository; keep private keys out of the repository.
4. After deploying, run `php lava migration run` from a Render shell when
   applying schema changes. Do not run `rollback-all` or `refresh` against
   production.
   Migration `005_add_auth_columns_to_users` adds the `name` and `password`
   columns required by browser and API registration, preserving existing user
   records. Run it before using `/register` on a database created with the
   older users schema.
5. Set `ADMIN_EMAIL` to the sole administrator's email and set
   `ADMIN_SETUP_TOKEN` to a long random secret. After deployment, visit
   `/register` over HTTPS and create the admin account with that exact email
   and token. Setup automatically closes once that account has a password;
   remove `ADMIN_SETUP_TOKEN` from Render afterwards. Public browser and API
   registration are disabled, and both web and API product routes require the
   configured admin account.

The Docker image installs `pdo_mysql` and starts PHP's built-in web server on
Render's `PORT` (with `10000` as a local fallback).

### API routes

- Public: `POST /api/login`, `POST /api/refresh`,
  `POST /api/logout`
- Bearer-token protected: `GET /api/products`,
  `GET /api/products/{id}`, `POST /api/products`,
  `PUT/PATCH /api/products/{id}`, `DELETE /api/products/{id}`

Send JSON with `Content-Type: application/json`. Product writes require
`product_name`, a non-negative numeric `price`, and a non-negative integer
`quantity` when creating a product. Send `Authorization: Bearer TOKEN_FROM_LOGIN`
for product endpoints.

## License

LavaLust Framework is open-source software licensed under the **[MIT License](https://opensource.org/licenses/MIT)**.

---

## Links

- **GitHub Repository:** [https://github.com/ronmarasigan/lavalust](https://github.com/ronmarasigan/lavalust)
- **Documentation:** [https://lavalust.netlify.app](https://lavalust.netlify.app)
- **Report an Issue:** [https://github.com/ronmarasigan/lavalust/issues](https://github.com/ronmarasigan/lavalust/issues)