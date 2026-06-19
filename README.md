
A simple E-commerce API only app

## 🚀 Key Features

* **Authentication:** Secure user login and register
* **RESTful API:** Structured API endpoints secured with Laravel Sanctum.

## 🛠️ Tech Stack

* **Backend:** PHP, Laravel Framework
* **Database:** MySQL

## ⚙️ Getting Started

Follow these sequential steps to configure your local development environment.

### Prerequisites

* PHP >= 8.3 installed locally
* Composer installed locally

### Installation Steps

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Michael-Anselim/e-commerce-api
   cd e-commerce-api
   ```

2. **Install PHP dependencies:**

   ```bash
   composer install
   ```

3. **Configure environment variables:**

   ```bash
   cp .env.example .env
   ```

   *Open the newly created `.env` file and update your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).*

4. **Generate application security key:**

   ```bash
   php artisan key:generate
   ```

5. **Run database migrations and seeders:**

   ```bash
   php artisan migrate --seed
   ```

6. **Launch the local development server:**

   ```bash
   php artisan serve
   ```

   *Your application will be live at `http://127.0.0.1:8000`.*

7. **To view live API documentations visit :**
   *Your application will be live at `http://127.0.0.1:8000/docs/api`.*

