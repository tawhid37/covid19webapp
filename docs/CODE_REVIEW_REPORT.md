# Code Review Report

**Project:** COVID-19 Self-Assessment Web App  
**Repo:** [tawhid37/covid19webapp](https://github.com/tawhid37/covid19webapp)  
**Reviewer:** SadmaFaahiim  
**Scope:** Full static code review of the application — conformance, correctness, security, and maintainability.

This report summarises **21 issues** found during a comprehensive review, the fixes applied for each, and how they are delivered through three **stackable** pull requests that merge cleanly with one another.

---

## Summary

| Severity | Count | Pull Request | Primary focus |
| -------- | ----- | ------------ | ------------- |
| 🔴 High    | 5  | [PR #3](https://github.com/tawhid37/covid19webapp/pull/3) | Security (auth, validation, middleware) |
| 🟠 Medium  | 6  | [PR #2](https://github.com/tawhid37/covid19webapp/pull/2) | Logic & HTML correctness |
| 🟢 Low     | 10 | [PR #1](https://github.com/tawhid37/covid19webapp/pull/1) | Code quality, dependencies, docs |

**Result:** the review produced **21 fixes in total**, all backwards-compatible with Laravel 7 / PHP ^7.4.

---

## 🔴 High Severity — Security (PR #3)

| ID    | Issue | Fix |
| ----- | ----- | --- |
| H-01 | Admin password was compared via `md5(...) == "21232f..."` — a hardcoded, immediately-decodable MD5 hash of `admin`, using a loose `==` comparison vulnerable to **PHP type juggling**. | Replaced with a **bcrypt** hash stored in `config/covid19.php` / `.env` (`ADMIN_PASSWORD_HASH`), verified with `Hash::check()` (strict, timing-safe). Password value is no longer hard-coded in source. |
| H-02 | The admin session stored the MD5 of the password, leaking credential material into the session payload. | Session now stores a **boolean `admin_authenticated` flag** instead of any derived credential. |
| H-03 | Assessment submissions relied primarily on client-side checks; the server had weak input handling. | All submissions (`store1`, `store2`, `finalResult`) are now validated on the server via **Form Request** classes (`StoreAssessmentRequest`, `StoreSymptomsRequest`, `StoreAdditionalSymptomsRequest`) enforcing required/type/size rules on name, age, sex, body temperature, and symptom arrays. |
| H-04 | Admin data was rendered on a **publicly reachable route** with no server-side access control. | Added an **`EnsureAdminAccess` middleware** (registered as the `admin` alias) and moved data rendering behind a new protected route `GET /adminshow`. Unauthenticated visitors are redirected to the login form. |
| H-05 | Logout called `session()->forget('data')`, removing only one key and leaving session data and the CSRF token intact (session-fixation risk). | Logout now calls **`session()->invalidate()`** (destroys all session data) followed by **`session()->regenerateToken()`** (fresh CSRF token) before redirecting home. |

**Files changed:** `CovidController.php`, new `EnsureAdminAccess.php`, `Kernel.php`, `routes/web.php`, `config/covid19.php`, `.env.example`.

---

## 🟠 Medium Severity — Logic & HTML (PR #2)

| ID    | Issue | Fix |
| ----- | ----- | --- |
| M-01 | Typo `$total_counte` → should be `$total_count` made the result branches **silently unreachable**. | Corrected both occurrences; the proper variable is now used. |
| M-02 | `@if/@elseif` chain in `finalresultPerson.blade.php` was not mutually exclusive — the `>= 5` branch caught all higher scores, so the `< 7` and `< 8` advice tiers could never display. | Restructured so every score maps correctly: `0` → Negative/safe, `< 5` → Negative/isolation, `< 7` → Positive/suspected, `< 8` → Positive/highly likely, `else` (`>= 8`) → Positive/almost confirmed. |
| M-03 | Orphaned `</form>` tags (no matching `<form>` opener) produced invalid HTML in `assessmentform`, `assessmentform2`, `assessmentform3`, `finalresultPerson`. | Removed the stray closing tags. |
| M-04 | `welcome.blade.php` had a stray `>` immediately after the closing `</style>` tag, breaking HTML parsing. | Removed the stray character. |
| M-05 | Migration column types were all `string` — `age`, `score`, `temperature` could not be sorted or compared numerically. | `Age`/`Score` → `unsignedInteger`; `Temperature` → `decimal(4, 1)`. |
| M-06 | jQuery CDN loaded over `http://`, blocked by browsers on HTTPS pages (mixed content); version `2.1.0` was outdated. | CDN changed to `https://`; jQuery upgraded `2.1.0` → `3.6.0`. |

---

## 🟢 Low Severity — Code Quality (PR #1)

| ID    | Fix |
| ----- | --- |
| L-01 | Add explicit `protected` properties to `Covid.php` for clarity. |
| L-02 | Modernise routes from deprecated string syntax to **array controller references** (`[Controller::class, 'method']`). |
| L-03 | Add 3 dedicated **Form Request** validation classes and type-hint them in the controller (`store1`, `store2`, `finalResult`). |
| L-04 | Bump PHP to `^7.4`; replace abandoned `fzaninotto/faker` with `fakerphp/faker`. |
| L-05 | Replace Laravel boilerplate **README** with project-specific documentation. |
| L-06 | Add `CovidSeeder` with 5 sample assessment records for demo data. |
| L-07 | Add `protected $fillable` to `Covid.php` for **mass-assignment safety**. |
| L-08 | Add `APP_KEY` placeholder and correct the default database name in `.env.example`. |
| L-09 | Fix typo `Syste m` → `System` in the layout footer. |
| L-10 | Rename `resources/views/Layouts/` → `layouts/` for case-consistency with `@extends`. |

---

## Merge Strategy

The three PRs are designed to **layer cleanly with zero conflicts**:

```
master
  └── PR #1 (low, tier 0)                  → base branch for PR #3
        └── PR #3 (high)  ← built on PR #1
PR #2 (medium, from master)  → does not touch files changed by PR #1/#3
```

- PR #2 was branched from `master` and does not modify README, routes, config, or the controller files touched by PR #1/#3.
- PR #3 was branched from the PR #1 branch, so the two apply in sequence without overlap.

This documentation branch (`docs/project-documentation`) is built **on top of the high-severity branch**, so the final PR (`#4`) also merges cleanly after all three.

---

## Validation Performed

- All changed/new PHP files pass `php -l` (syntax) checks.
- `composer.json` validated as well-formed JSON.
- The bcrypt hash verifies with `password_verify('admin', <hash>) === true`.
- The `Layouts` → `layouts` folder rename is tracked correctly by Git.
- Git confirms all PRs rebase/merge without conflict (verified via `git merge --no-commit --no-ff` dry runs).

---

## Follow-up — Admin Hardening (PR #5)

Two of the recommendations below were implemented in a dedicated follow-up pull request — [PR #5](https://github.com/tawhid37/covid19webapp/pull/5):

| ID | Recommendation | Status |
| -- | -------------- | ------ |
| R-01 | CSRF-safe logout | ✅ **Done** — logout is now `POST /logout` (named route) inside the `admin` middleware group, triggered from a Blade form with a `@csrf` token instead of a GET link. |
| R-02 | Brute-force protection on admin login | ✅ **Done** — `POST /adminpass` is wrapped in Laravel's built-in `throttle:5,1` middleware (5 attempts/minute/IP; `429` beyond that). |

### Remaining recommendations

- Introduce an automated test suite (unit + feature) covering the scoring thresholds and admin auth.
- Consider rotating the demo admin password before any real deployment.
- When the app is deployed publicly, serve over HTTPS and configure proper database credentials via environment variables (never in source).
