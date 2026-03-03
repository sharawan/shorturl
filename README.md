

## URL Shortener Assignment

This project implements a simple multi-company URL shortener with role-based access control.

### Requirements

- PHP 8.2+
- Composer
- Node.js (only if you want to rebuild assets, not required for core features)
- SQLite or MySQL

### Setup

1. **Clone the repository**

   ```bash
   git clone <your-public-repo-url>
   cd testproject
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Environment**

   Copy the example environment file and configure your database (SQLite or MySQL):

   ```bash
   cp .env.example .env
   ```

   Example SQLite configuration in `.env`:

   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=${PWD}/database/database.sqlite
   ```

   Create the SQLite database file if using SQLite:

   ```bash
   mkdir -p database
   touch database/database.sqlite
   ```

4. **Application key**

   ```bash
   php artisan key:generate
   ```

5. **Migrate and seed**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   Seeding creates a **SuperAdmin** user using raw SQL:

   - Email: `superadmin@example.com`
   - Password: `password`

6. **Run the application**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000/login` and log in as SuperAdmin using the credentials above.

### Roles and Behavior

- **Roles**: `super_admin`, `admin`, `member`.
- **Short URLs**
  - Admin, Member **can** create short URLs.
  - Admin can send Invite to member and admin in their own company.
  - Superadmin can send invite to other company admin.
  - Member can create and see own short URLs created by themselves.
  - Short URLs are **publicly resolvable**; all users can access `/s/{code}`.

### Tests

Run the automated tests:

```bash
php artisan test
```
