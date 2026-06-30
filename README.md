# Laravel School Application

This markdown file provides documentation on the application details, package versions, installation steps, database seeding, master password configuration, and admin credentials.

## Version Details
The application is built using the following core technologies:
- **PHP**: `^8.3`
- **Laravel Framework**: `^13.8`
- **Spatie Laravel Permission**: `^8.1` (used for role-based authorization: `admin`, `teacher`, `student`, `parent`)
- **Yajra Laravel DataTables**: `^13.1` (used for loading paginated datatables dynamically)

## Installation Steps
Follow these steps to set up the project locally:

1. **Clone the repository** (if not already cloned) and navigate to the project directory:
   ```bash
   cd artisan-app
   ```

2. **Install composer dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment File**:
   Duplicate the example `.env` file and generate the application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set Up Database**:
   Configure your database credentials inside the `.env` file and run the migrations:
   ```bash
   php artisan migrate
   ```

5. **Start local servers**:
   ```bash
   php artisan serve
   ```

## Seeder Steps
To seed the system database with roles and the default admin user account:

1. **Run Database Seeders**:
   ```bash
   php artisan db:seed
   ```
   This will run `DatabaseSeeder` which sequentially calls:
   - `RoleSeeder`: Creates the application roles (`admin`, `teacher`, `student`, `parent`) from the dynamic `Role` enum.
   - `UserSeeder`: Creates the default admin account.

## Master Password Configuration
- **Configuration Path**: `config/site.php`
- **Value**: `'default_password' => "Test@123"`
- **Usage**: When creating users (Teachers, Students, and Parents), the system defaults their password hash to the master password value defined in the site configuration file.

## Default Admin Credentials
You can log into the application with the following default administrator account:
- **Email**: `admin@example.com`
- **Password**: `Test@123` (or the current value set in `config/site.php`)
