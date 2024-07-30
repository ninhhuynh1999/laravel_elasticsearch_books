# Laravel 11 Elasticsearch 8 API with Repository and Service Pattern

This project demonstrates how to integrate Elasticsearch 8 into a Laravel 11 application using the Repository and Service pattern for a clean and maintainable architecture. It showcases building a RESTful API that leverages Elasticsearch for powerful search capabilities.

## Features

* **Laravel 11 and Elasticsearch 8:** Utilizes the latest versions of both frameworks.
* **Repository and Service Pattern:**  Promotes code organization, separation of concerns, and testability.
* **RESTful API:**  Provides endpoints for interacting with data, powered by Elasticsearch.
* **Queryable Trait:** Offers a reusable solution for applying complex filters to Eloquent models within repositories.
* **Automatic Index Updates:** Leverages the `babenkoivan/elastic-scout-driver` and `babenkoivan/elastic-scout-driver-plus` packages to ensure Elasticsearch indices are automatically updated when models are created, updated, or deleted.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ninhhuynh1999/laravel_elasticsearch_books.git
   ```
2. **Install Composer dependencies:**
   ```bash
   composer install
   ```
3. **Configure Environment:**
   - Copy `.env.example` to `.env` and update database and Elasticsearch credentials.
   - Set up your Elasticsearch connection details in the `config/elastic.php` file. 
4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
5. **Run Migrations and Seeders (Optional):**
   ```bash
   php artisan migrate --seed 
   ```

## Usage

1. **Start Elasticsearch:** Refer to Elasticsearch documentation to start your Elasticsearch server. 
2. **Index Your Data:** Use the provided Artisan commands or programmatically index your models into Elasticsearch.
3. **Explore the API:**  The application will expose API endpoints to search, filter, and interact with your data. Refer to the API documentation for specific endpoints and usage examples.

## Project Structure

```
app/
├── Classes/       // DTOs (Data Transfer Objects), Request Filters, etc. 
├── Models/         // Eloquent models
├── Repositories/    // Repository interfaces and implementations
├── Services/        // Service interfaces and implementations
├── Traits/          // Reusable traits, including the "Queryable" trait
routes/
    api.php       // API routes
```

## Key Technologies

* **PHP 8.1+**
* **Laravel 11**
* **Elasticsearch 8**
* **babenkoivan/elastic-scout-driver**
* **babenkoivan/elastic-scout-driver-plus**

## Contributing

Feel free to contribute to this project by submitting issues or pull requests.

## License

This project is licensed under the [MIT License](LICENSE).