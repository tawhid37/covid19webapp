# Contributing to the COVID-19 Self-Assessment Web App

Thank you for your interest in contributing. Please take a moment to review these guidelines so the review and merge process stays smooth for everyone.

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Testing](#testing)
- [Pull Request Process](#pull-request-process)
- [Security](#security)
- [Reporting Issues](#reporting-issues)

---

## Code of Conduct

Be respectful, constructive, and inclusive. Harassment or abusive behaviour is not tolerated. If you witness unacceptable behaviour, please report it to the maintainers.

---

## Getting Started

1. Fork the repository on GitHub.
2. Clone your fork locally:

   ```bash
   git clone https://github.com/<your-username>/covid19webapp.git
   cd covid19webapp/covid19
   ```

3. Create a topic branch off `master`:

   ```bash
   git checkout -b fix/your-short-description
   ```

4. Set up the environment — see the [README](README.md#installation) for full instructions:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   npm install && npm run prod
   ```

---

## Development Workflow

- Work in a **short-lived feature branch** named after the change, e.g. `fix/login-validation` or `feature/export-csv`.
- Keep the change **small and focused**. One logical change per pull request.
- Keep your branch up to date with upstream `master`:

  ```bash
  git remote add upstream https://github.com/tawhid37/covid19webapp.git
  git fetch upstream
  git rebase upstream/master
  ```

- Run the app locally and manually verify the affected flows before opening a pull request.

---

## Coding Standards

This is a **Laravel 7 (PHP 7.4)** application.

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) style where possible.
- Use **bound methods semantics** — assume guzzlephp and friends are resolved through Composer auto-discovery rather than manual aliasing.
- Name variables for **intent**, not implementation (e.g. `hasSymptoms` instead of `isdata`).
- Prefer **small, single-responsibility methods** over long inline logic.
- Use **Laravel's built-in features**: Form Requests for validation, `Hash` for password storage, middleware for route protection, and Blade auto-escaping for output.
- Do **not** store secrets (passwords, hashes) directly in controllers; use config + environment variables.

---

## Testing

Currently the project uses **no automated test suite**. Until tests are introduced:

- Manually verify every flow you touch (new, edit, result, admin).
- Confirm the risk score and result advice match the documented thresholds in the [README](README.md#risk-score-interpretation).
- Ensure no PHP errors or `laravel.log` warnings are introduced.

When a test suite is added, please update this section and add tests for any new logic.

---

## Pull Request Process

1. Update the **CHANGELOG.md** with a short description of the change.
2. If the change alters behaviour, update the **README.md** accordingly.
3. Ensure the pull request builds and applies cleanly against `master`.
4. Open the pull request against `tawhid37/covid19webapp:master` with:
   - A **concise, descriptive title** (e.g. `fix: validate admin password with bcrypt`).
   - A **body explaining the what and why**, including any related issue numbers.
5. Respond to review feedback and push follow-up commits to the same branch.

---

## Security

Because this application handles user-entered health information, security is a priority. When reviewing or writing code:

- **Never** trust client-side input — always validate on the server.
- Use **bcrypt** and Laravel's `Hash` facade for passwords.
- Keep sensitive/admin functionality behind **middleware**.
- Perform state-changing actions via **`POST` forms with `@csrf` tokens** — never GET links (see the CSRF-safe logout pattern).
- Protect authentication endpoints against brute-force with Laravel's **`throttle`** middleware.
- Rely on **Blade auto-escaping** and parameterised queries to prevent XSS and SQL injection.
- Use `https://` when referencing external assets.

If you discover a security vulnerability, **do not** open a public issue. Contact the maintainers privately so it can be addressed before disclosure.

---

## Reporting Issues

- Search existing issues and pull requests before opening a new one to avoid duplicates.
- Provide a **clear, reproducible** report: expected behaviour, actual behaviour, steps to reproduce, and environment details (PHP version, OS, database).
- For bug fixes, consider attaching a minimal reproduction.

Thank you for contributing!
