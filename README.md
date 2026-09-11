# COVID-19 Self-Assessment Web App

A web application built with **Laravel 7** and **MySQL** that lets users perform a self-assessment based on COVID-19 symptoms. The system calculates a risk score from the user's answers and provides guidance on what they should do — stay home, consult a doctor, or visit a hospital.

> **Disclaimer:** This application is built for software development and educational purposes only. It does **not** provide accurate medical results or diagnoses. User-provided information is not disclosed or stored anywhere outside this demo system.

---

## Features

- **Multi-step assessment form** — collects personal details, body temperature, and symptoms across 3 steps
- **Automatic risk scoring** — computes a score based on symptoms and temperature
- **Personalized advice** — suggests the appropriate next step based on the computed score
- **Admin panel** — view all submitted assessment records (password protected)

---

## Tech Stack

| Layer      | Technology               |
| ---------- | ------------------------ |
| Backend    | Laravel 7 (PHP)          |
| Database   | MySQL                    |
| Frontend   | Blade templates, jQuery  |
| Build      | Laravel Mix (Webpack)    |

---

## Installation

### Prerequisites

- PHP **7.4+** with required extensions
- Composer
- MySQL

### Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/tawhid37/covid19webapp.git
   cd covid19webapp/covid19
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Configure environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update database credentials** in `.env`

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=covid19
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Compile frontend assets**

   ```bash
   npm install
   npm run prod
   ```

7. **Start the development server**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

---

## Usage

1. Open the home page and click **Assessment Form**.
2. Fill in your name, age, gender, and body temperature in **Step 1**.
3. Select any symptoms you are experiencing in **Step 2** and **Step 3**.
4. View your **risk score** and the recommended action on the result page.

### Admin Access

- Navigate to the **ADMIN** link on the home page.
- Enter the admin password (set in `CovidController::adminenter`) to view all submitted records.

---

## Project Structure

```
app/
  Http/
    Controllers/CovidController.php   # Main application logic
    Requests/                          # Form Request validation classes
  Covid.php                            # Assessment record model
database/
  migrations/                          # Database schema
  seeds/                               # Demo data seeders
resources/
  views/                               # Blade templates
routes/web.php                         # Application routes
```

---

## Contributing

Contributions are welcome! Please open an issue first to discuss what you would like to change, then submit a pull request.

---

## License

This project is open-sourced under the [MIT license](LICENSE).
