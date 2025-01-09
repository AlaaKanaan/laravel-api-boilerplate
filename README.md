# Laravel Standalone API

Laravel Standalone API is a boilerplate designed for developers who want to kickstart projects using Laravel as a backend API. Whether you're building a Single Page Application (SPA), a mobile app, or integrating with third-party systems, this boilerplate provides a robust and scalable foundation.

Out-of-the-box, it includes **REST API authentication** powered by **Laravel Sanctum**, MySQL integration, and best practices for API development. It is built using **Laravel 11**, the latest version, to leverage the most recent features and improvements.

## Features

- **RESTful API**: Structured and clean RESTful API endpoints.
- **API Versioning**: Structure API with versioning (e.g., `/api/v1`).
- **Authentication**: Token-based authentication using **Laravel Sanctum**.
- **User Management**: Pre-built endpoints for user registration, login, logout, and password reset.
- **MySQL Integration**: Ready-to-use MySQL database schema for seamless integration.
- **Error Handling**: Centralized error handling for consistent API responses.
- **Localization**: Multilingual support for error messages and responses.


## Tech Stack

Nothing is included in this framework unless it has been thoroughly tested and proven on real-world projects. Applications built with this framework come with well-considered, reliable technical decisions included right out of the box:

| Library                  | Category  | Version  | Description                                                    |
|--------------------------|-----------|----------|----------------------------------------------------------------|
| Laravel                  | Framework | v11.36.1 | The best cross-platform framework                              |
| JSONAPI                  | Package   | v5.0.2   | Feature-rich JSON:API compliant APIs for Laravel applications. |
| Laravel Media Library    | Package   | v11.11   | package can associate all sorts of files with Eloquent models  |

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/laravel-standalone-api.git
   cd laravel-standalone-api
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the `.env` file:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in the `.env` file and run migrations:
   ```bash
   php artisan migrate
   ```

6. Serve the application:
   ```bash
   php artisan serve
   ```

## Use Cases

- **Single Page Applications (SPAs)**: A seamless backend for SPAs built with frameworks like Vue.js, React.js, or Angular.
- **Mobile Apps**: Fully compatible with mobile app development using Flutter, React Native, Swift, or Kotlin.
- **Third-Party Integration**: Easily expose APIs for other systems to consume.
- **Microservices**: Use as a standalone service in a larger microservice architecture.

## Roadmap and Additional Features (Suggestions)

Consider adding the following features to expand the boilerplate's functionality:

1. **Database Options**: Add support for MongoDB, PostgreSQL, or SQLite.
2. **Role and Permission Management**: Integrate a package like **Spatie Laravel Permissions**.
3. **OAuth2 Authentication**: Add **Laravel Passport** for advanced use cases.
4. **File Uploads**: Include endpoints for handling file uploads (e.g., images or documents).
5. **WebSocket Support**: Add real-time functionality using **Laravel WebSockets**.
6. **Localization**: Multilingual support for error messages and responses.
7. **Audit Logs**: Log user activities and API usage.
8. **Rate Limiting by User Role**: Customize rate limiting rules for different user roles.
9. **API Metrics Dashboard**: Build a simple dashboard to monitor API usage and performance.

## API Documentation

This project includes auto-generated API documentation using **Swagger/OpenAPI**. Access the documentation at:
```
/api/docs
```

## Contributing

Contributions are welcome! Submit a pull request or create an issue to suggest features or report bugs.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
