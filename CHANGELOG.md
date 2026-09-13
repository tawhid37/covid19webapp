# Changelog

All notable changes to the **COVID-19 Self-Assessment Web App** are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/). Entries below are marked **Unreleased** while the corresponding pull requests are still open for review.

---

## [Unreleased]

### Overview

A systematic **code-quality, security, and production-readiness** review of the application produced fixes delivered through five pull requests:

- **10 low-severity** code-quality fixes — [PR #1](https://github.com/tawhid37/covid19webapp/pull/1)
- **6 medium-severity** logic/HTML fixes — [PR #2](https://github.com/tawhid37/covid19webapp/pull/2)
- **5 high-severity** security fixes — [PR #3](https://github.com/tawhid37/covid19webapp/pull/3)
- **2 admin-hardening** fixes (CSRF-safe logout + brute-force protection) — [PR #5](https://github.com/tawhid37/covid19webapp/pull/5)
- **8 production-grade enhancements** (pagination, CSV export, security headers, CI, scoring service + tests, schema indexes, session hardening, admin a11y) — [PR #10](https://github.com/tawhid37/covid19webapp/pull/10)

### Production Enhancements (PR #10)

- 🧾 **Admin pagination** — `adminshow()` now uses `paginate(10)` + `orderByDesc('id')`; the view renders a record summary and pagination links instead of dumping every row.
- 📥 **CSV export** — new `GET /adminshow/export` route (behind `admin` middleware) streams a timestamped CSV of all records.
- 🛡️ **Security headers middleware** — `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `X-XSS-Protection`, `Permissions-Policy` applied globally; HSTS when HTTPS.
- 🤖 **CI pipeline (GitHub Actions)** — PHP 7.4 lint (`php -l` on every file), `composer validate`, `composer test`, and frontend asset build on every PR.
- ✅ **Scoring service + unit tests** — scoring logic extracted from the controller into `App\Services\ScoringService` with 11 tests covering all score tiers and temperature boundaries. The controller's result flow is behaviour-identical (verified against 13 vectors).
- 🗄️ **Schema indexes** — additive migration adds indexes on `created_at` and `Result`.
- 🔒 **Session hardening** — `same_site` env-configurable (default `lax`), secure cookie override documented in `.env.example`.
- ♿ **Admin table a11y** — responsive wrapper, `scope`/`aria` attributes, semantic table markup.

### Admin Hardening — Logout & Brute-Force (PR #5)

- 🚪 **CSRF-safe logout** — logout moved from `GET /logout` to a **`POST /logout`** route (named `logout`) inside the `admin` middleware group. The admin view now submits a form with a **`@csrf` token** instead of a plain link, eliminating the CSRF/logout-abuse vector.
- 🛡️ **Rate-limited admin login** — `POST /adminpass` is now wrapped in Laravel's built-in **`throttle:5,1`** middleware, limiting brute-force password guessing to **5 attempts per minute per IP** (429 response beyond that).

### High — Security (PR #3)

- 🔒 **H-01 / H-02 — Replace insecure MD5 admin password** — the admin login no longer compares a hardcoded, easily-decodable MD5 hash (`"21232f..."`) with a loose `==` operator (vulnerable to PHP type juggling). The password is now a **bcrypt hash** stored in `config/covid19.php` / `.env` (`ADMIN_PASSWORD_HASH`) and verified with Laravel's `Hash::check()` (strict, timing-safe). The session stores a boolean `admin_authenticated` flag instead of leaking the password's MD5.
- 🛡️ **H-04 — Protect admin routes** — added a dedicated `EnsureAdminAccess` middleware registered as the `admin` route alias; moved data rendering behind a new protected route `GET /adminshow` so unauthenticated visitors are redirected to the login form.
- 🔒 **H-05 — Harden logout** — replaced `session()->forget('data')` (one key only) with `session()->invalidate()` followed by `session()->regenerateToken()`, preventing session/CSRF-token fixation.
- ✅ **H-03 — Server-side input validation** — all assessment submissions are validated via Form Request classes; Form Requests introduced in PR #1 are now enforced end-to-end.
- 👥 Admin access is fully server-side protected (see [README → Admin Access](README.md#admin-access)).

### Medium — Logic & HTML (PR #2)

- 🧮 **M-01 / M-02 — Fix broken result logic** — corrected the typo `$total_counte` → `$total_count` (which made branches silently unreachable) and restructured the `@if/@elseif` chain so every score maps to the correct advice tier. Previously the `>= 5` branch swallowed all higher scores and the `< 7` / `< 8` advice levels could never display.
- 🌐 **M-06 — Mixed-content jQuery** — CDN changed from `http://` to `https://` to avoid browser mixed-content blocking; jQuery upgraded `2.1.0` → `3.6.0`.
- 🗑️ **M-03 — Remove stray `</form>` tags** — cleaned orphaned closing tags in `assessmentform`, `assessmentform2`, `assessmentform3`, and `finalresultPerson` (invalid HTML).
- 🧱 **M-04 — Fix `welcome.blade.php` HTML** — removed a stray `>` after the closing `</style>` tag.
- 🗄️ **M-05 — Correct column types** — migration now uses typed columns: `age`/`score` as `unsignedInteger`, `temperature` as `decimal(4,1)` (previously all `string`).

### Low — Code Quality (PR #1)

- 🧊 **L-01 / L-07 — Model hardening** — explicit protected properties on `Covid.php`; `$fillable` added for mass-assignment safety.
- 🚏 **L-02 — Route modernization** — routes updated from deprecated string syntax to array controller references.
- ✅ **L-03 — Form Request validation** — three dedicated Form Request classes (`StoreAssessmentRequest`, `StoreSymptomsRequest`, `StoreAdditionalSymptomsRequest`) added and type-hinted in the controller.
- 📦 **L-04 — Dependency hygiene** — PHP bumped to `^7.4`; abandoned `fzaninotto/faker` replaced with `fakerphp/faker`.
- 📘 **L-05 — README rewrite** — replaced default Laravel boilerplate with project-specific documentation.
- 🗂️ **L-06 — Demo seeder** — added `CovidSeeder` with 5 sample assessment records.
- ⚙️ **L-08 — Environment defaults** — added `APP_KEY` placeholder and corrected the default database name in `.env.example`.
- ✏️ **L-09 — Typo fix** — corrected `Syste m` → `System` in the layout footer.
- 📁 **L-10 — Folder rename** — renamed `resources/views/Layouts/` → `layouts/` for case-consistency with `@extends`.

> Each fix is documented in detail with rationale in the [Code Review Report](docs/CODE_REVIEW_REPORT.md).

---

## [0.1.0] — Initial Snapshot

- Multi-step self-assessment form (3 steps) with symptom selection.
- Automatic risk scoring with personalised guidance.
- Password-protected admin panel to view submitted records.
- MySQL persistence with migrations and demo seed data.
- Laravel Mix frontend build pipeline.
