# Laravel Standalone API

Laravel Standalone API is a boilerplate designed for developers who want to kickstart projects using Laravel as a backend API. Whether you're building a Single Page Application (SPA), a mobile app, or integrating with third-party systems, this boilerplate provides a robust and scalable foundation.

Out-of-the-box, it includes **REST API authentication** powered by **Laravel Sanctum**, MySQL integration, and best practices for API development. It is built using **Laravel 11**, the latest version, to leverage the most recent features and improvements.

## Features

- **RESTful API**: Structured and clean RESTful API endpoints.
- **Authentication**: Token-based authentication using **Laravel Sanctum**.
- **User Management**: Pre-built endpoints for user registration, login, logout, and password reset.
- **MySQL Integration**: Ready-to-use MySQL database schema for seamless integration.
- **CORS Support**: Configured for cross-origin resource sharing to support SPAs and mobile apps.
- **Mobile App Compatibility**: Designed to work with mobile apps (iOS, Android) for seamless integration.
- **Third-Party Integration**: Easily connect with third-party services or systems.
- **Error Handling**: Centralized error handling for consistent API responses.
- **API Documentation**: Auto-generated API documentation using **Swagger/OpenAPI**.
- **Rate Limiting**: Configurable API rate limiting to protect your application.
- **Environment Configuration**: `.env` file support for secure and easy configuration.
- **Modular Codebase**: Clean and modular structure to easily extend and maintain.

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

## Usage

### Authentication Endpoints

- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Logout**: `POST /api/logout`
- **User Info**: `GET /api/user`
- **Password Reset**: `POST /api/password/reset`

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
8. **API Versioning**: Structure API with versioning (e.g., `/api/v1`).
9. **Notifications**: Pre-built email and push notification endpoints.
10. **Rate Limiting by User Role**: Customize rate limiting rules for different user roles.
11. **API Metrics Dashboard**: Build a simple dashboard to monitor API usage and performance.

## API Documentation

This project includes auto-generated API documentation using **Swagger/OpenAPI**. Access the documentation at:
```
/api/docs
```

## Contributing

Contributions are welcome! Submit a pull request or create an issue to suggest features or report bugs.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
