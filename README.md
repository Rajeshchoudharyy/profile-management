# Profile Management

This is a Laravel PHP project for profile management.

## Requirements

- PHP >= 8.0
- Composer
- MySQL or compatible database
- 
## Installation

Follow these steps to get the project running on your local machine:

### 1. Clone the repository

```bash
git clone https://github.com/Rajeshchoudharyy/profile-management.git
cd profile-management
```

### 2. Install dependencies

```bash
composer install
npm install
npm run dev
```

### 3. Environment Setup

```bash
cp .env.example .env
```

Edit the `.env` file to set up your database connection:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Run migrations

```bash
php artisan migrate
```

### 7. Start the development server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`
