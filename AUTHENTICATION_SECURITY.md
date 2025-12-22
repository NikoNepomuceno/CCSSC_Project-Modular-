# Authentication Security Features

## Overview

This document lists the security measures implemented in the authentication system of this application.

---

## 1. Rate Limiting

### IP-Based Rate Limiting

-   **Maximum Attempts**: 5 failed login attempts per IP address
-   **Time Window**: 15 minutes
-   **Implementation**: `LoginAttempt::isIpRateLimited()`
-   **Files**: `app/Models/LoginAttempt.php`, `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Throttles brute force attacks from a single IP.

### Email-Based Rate Limiting

-   **Maximum Attempts**: 5 failed login attempts per email address
-   **Time Window**: 15 minutes
-   **Implementation**: `LoginAttempt::isEmailRateLimited()`
-   **Files**: `app/Models/LoginAttempt.php`, `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Throttles targeted brute force attacks on specific accounts.

---

## 2. Password Security

### Password Hashing

-   **Algorithm**: Bcrypt (Laravel default)
-   **Implementation**: `password` casted as `hashed`
-   **Files**: `app/Models/Admin.php`, `app/Models/OrganizationUser.php`
-   **Purpose**: Passwords are never stored in plaintext.

### Password Visibility Protection

-   **Hidden Fields**: `password`, `remember_token`
-   **Implementation**: `$hidden` property on models
-   **Files**: `app/Models/Admin.php`, `app/Models/OrganizationUser.php`
-   **Purpose**: Prevents password leakage in serialized output (e.g. JSON).

### Password Validation

-   **Rules**: Required, string, minimum length 8, confirmed (where applicable)
-   **Implementation**: Laravel validation rules
-   **Files**: `app/Modules/Admin/Http/Controllers/AuthController.php`, `app/Modules/Admin/Http/Controllers/OrganizationUserController.php`
-   **Purpose**: Enforces non-empty and reasonably strong passwords.

---

## 3. JWT Access Tokens

### Token Properties

-   **TTL**: 15 minutes
-   **Algorithm**: HS256 (HMAC SHA-256)
-   **Secret**: `config('app.key')`
-   **Claims**: `iss`, `sub`, `type`, `session_id`, `iat`, `exp`
-   **Implementation**: `JwtService::generateAccessToken()`
-   **File**: `app/services/JwtService.php`
-   **Purpose**: Short‑lived, signed tokens bound to a specific session.

### Token Validation

-   **Signature Check**: Verifies JWT using HS256 + app key
-   **Expiry Check**: Rejects expired tokens
-   **Session Check**: Ensures linked session exists and is valid
-   **User Check**: Ensures referenced user exists
-   **Guard Check**: Optional guard/type check for correct user type
-   **Implementation**: `ValidateAccessToken` middleware
-   **File**: `app/Http/Middleware/ValidateAccessToken.php`
-   **Purpose**: Ensures only valid, unexpired tokens tied to active sessions are accepted.

---

## 4. Refresh Token Security

### Generation

-   **Size**: 64 random bytes → 128 hex characters
-   **Source**: `random_bytes(64)` then `bin2hex`
-   **Implementation**: `SessionService::generateRefreshToken()`
-   **File**: `app/services/SessionService.php`
-   **Purpose**: High‑entropy, unguessable refresh tokens.

### Storage

-   **Format**: SHA-256 HMAC hash
-   **Key**: `config('app.key')`
-   **Implementation**: `SessionService::hashToken()`
-   **DB Column**: `auth_sessions.refresh_token_hash`
-   **Purpose**: Database never stores refresh tokens in plaintext.

### Rotation

-   **On Refresh**: Old token invalidated, new token generated
-   **Tracking**: `previous_token_hash`, `rotation_count`, `last_rotated_at`
-   **Implementation**: `SessionService::rotateToken()`
-   **File**: `app/services/SessionService.php`
-   **Purpose**: Minimizes impact window if a refresh token is intercepted.

### Reuse Detection

-   **Old Token Check**: If a previously used token is seen again, session is revoked
-   **Revocation Reason**: `token_reuse_detected`
-   **Implementation**: `SessionService::rotateToken()`
-   **Purpose**: Detects and reacts to refresh token theft.

### Cookie Settings (Refresh Token)

-   **Name**: `refresh_token`
-   **Scope**: Path `/`
-   **Lifetime**: 30 days
-   **HttpOnly**: `true` (not readable by JavaScript)
-   **Secure**: Matches `request->secure()` (HTTPS only when applicable)
-   **SameSite**: `Lax` for web, `Strict` for API responses
-   **Implementation**: `AuthController::login()` / `AuthController::apiLogin()`
-   **File**: `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Resists XSS‑based token theft and CSRF exploitation.

---

## 5. Session Management

### Session Model

-   **ID Type**: UUID (string, non‑incrementing)
-   **Fields**: `refresh_token_hash`, `previous_token_hash`, `rotation_count`, `expires_at`, `last_activity_at`, `inactivity_timeout_minutes`, `ip_address`, `user_agent`, `device_name`, `csrf_token_hash`, `is_revoked`, `revoked_at`, `revoke_reason`
-   **Implementation**: `AuthSession` model with `HasUuids`
-   **File**: `app/Models/AuthSession.php`

### Lifetime & Inactivity

-   **Absolute Expiry**: 30 days from creation
-   **Inactivity Timeout**: 60 minutes after last activity
-   **Validation**: `AuthSession::isValid()`
-   **Sliding Expiry**: `SessionService::touchSession()` called on token validation
-   **Files**: `app/Models/AuthSession.php`, `app/services/SessionService.php`, `app/Http/Middleware/ValidateAccessToken.php`
-   **Purpose**: Sessions expire both by age and by inactivity.

### Revocation

-   **Single Session Revocation**: `SessionService::revokeSession()`
-   **Bulk Revocation for User**: `SessionService::revokeAllUserSessions()` (optionally excluding current)
-   **On Logout**: Associated session(s) marked revoked with reason `logout`
-   **User‑Initiated Revocation**: Controller endpoints to revoke specific or other sessions
-   **Files**: `app/services/SessionService.php`, `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Allows terminating compromised or unwanted sessions.

### Tracking & Device Info

-   **Tracked Data**: IP address, user agent, derived device name, timestamps
-   **Device Parsing**: `parseDeviceName()` infers human‑readable device label
-   **File**: `app/services/SessionService.php`
-   **Purpose**: Aids in security monitoring and user session management UI.

---

## 6. CSRF Protection (API)

### Double-Submit Cookie Pattern

-   **Cookie Name**: `api_csrf_token`
-   **Header Names**: `X-CSRF-TOKEN` or `X-Api-Csrf-Token`
-   **Token Generation**: Random 32 bytes → 64 hex characters
-   **Storage**: `csrf_token_hash` (SHA-256 HMAC) in `auth_sessions`
-   **Files**: `app/Http/Middleware/VerifyApiCsrf.php`, `app/services/SessionService.php`, `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Protects state‑changing API calls from CSRF.

### Validation

-   **Safe Methods**: GET, HEAD, OPTIONS bypass CSRF check
-   **Session Binding**: CSRF token tied to the authenticated session (JWT or refresh cookie)
-   **Comparison**: Uses `hash_equals()` to compare hashes securely
-   **Files**: `app/Http/Middleware/VerifyApiCsrf.php`, `app/services/SessionService.php`
-   **Purpose**: Prevents CSRF while resisting timing attacks.

### CSRF Cookie Settings

-   **Name**: `api_csrf_token`
-   **HttpOnly**: `false` (must be read by frontend JavaScript)
-   **Secure**: Matches `request->secure()`
-   **SameSite**: `Lax`
-   **Lifetime**: 30 days
-   **File**: `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Enables SPA/JS clients to read token while keeping transport secure.

---

## 7. Laravel Session Hardening

### On Login

-   **Action**: Laravel session ID regenerated
-   **Code**: `$request->session()->regenerate()`
-   **File**: `AuthController::login()`
-   **Purpose**: Prevents session fixation.

### On Logout

-   **Actions**:
    -   `Auth::guard('admin')->logout()`
    -   `$request->session()->invalidate()`
    -   `$request->session()->regenerateToken()`
-   **File**: `AuthController::logout()`
-   **Cookies Cleared**: `refresh_token`, `api_csrf_token`
-   **Purpose**: Cleanly logs out user and invalidates old CSRF token and cookies.

---

## 8. Login Attempt Logging

### Logged Data

-   **Fields**: IP address, email, guard, success flag, failure reason, timestamp
-   **API & Web**: Both web login and API login paths log attempts
-   **Implementation**: `LoginAttempt::log()`
-   **Files**: `app/Models/LoginAttempt.php`, `app/Modules/Admin/Http/Controllers/AuthController.php`
-   **Purpose**: Provides an audit trail and supports rate limiting.

### Cleanup

-   **Old Entry Cleanup**: `LoginAttempt::clearOldAttempts()`
-   **Purpose**: Limits storage and keeps data set focused on recent behavior.

---

## 9. Input Validation

### Email

-   **Rules**: Required, valid email format
-   **Implementation**: `$request->validate(['email' => ['required', 'email'], ...])`
-   **File**: `AuthController::login()`, `AuthController::apiLogin()`

### Password

-   **Rules**: Required for login; string, min:8, confirmed for account management
-   **Files**: `AuthController`, `OrganizationUserController`
-   **Purpose**: Ensures well‑formed, non‑empty credentials.

---

## 10. Guard-Based Authorization

### Token Type vs Guard

-   **Token Claim**: `type` (e.g. `Admin`, `OrganizationUser`)
-   **Guard Check**: Middleware compares `payload['type']` to expected guard
-   **Implementation**: `ValidateAccessToken` middleware
-   **File**: `app/Http/Middleware/ValidateAccessToken.php`
-   **Purpose**: Ensures tokens are only usable against appropriate resources.

---

## 11. Security Breach Detection

### Refresh Token Reuse

-   **Detection**: If incoming refresh token matches `previous_token_hash` instead of current
-   **Response**: Session is revoked with reason `token_reuse_detected`
-   **Implementation**: `SessionService::rotateToken()`
-   **File**: `app/services/SessionService.php`
-   **Purpose**: Automatically reacts to replayed refresh tokens.

---

## 12. Secure Cookie Configuration (Summary)

### Refresh Token Cookie

-   **HttpOnly**: Yes
-   **Secure**: Yes (in HTTPS)
-   **SameSite**: Lax/Strict depending on flow
-   **Lifetime**: 30 days

### CSRF Token Cookie

-   **HttpOnly**: No (JS must read it)
-   **Secure**: Yes (in HTTPS)
-   **SameSite**: Lax
-   **Lifetime**: 30 days

**Files**: `app/Modules/Admin/Http/Controllers/AuthController.php`

---

## 13. Session Activity Tracking

### Sliding Activity Window

-   **Mechanism**: `touchSession()` updates `last_activity_at` on each authenticated API request
-   **Files**: `ValidateAccessToken` middleware, `SessionService`

### Remaining Time Helpers

-   **Helpers**: `expires_in`, `inactivity_expires_in` accessors on `AuthSession`
-   **File**: `app/Models/AuthSession.php`

---

## Summary

This authentication system implements multiple layers of defenses:

-   **Rate limiting** against brute force
-   **Secure password storage** and validation
-   **Short‑lived JWT access tokens** bound to sessions
-   **Hashed, rotating refresh tokens** with reuse detection
-   **Robust session model** with absolute/inactivity expiry and revocation
-   **API CSRF protection** via double‑submit cookies
-   **Session regeneration** on login/logout
-   **Comprehensive login attempt logging**
-   **Guard‑aware authorization**
-   **Secure cookie flags** (HttpOnly, Secure, SameSite)

Together, these mitigate common attack vectors including brute force, token theft and replay, CSRF, session fixation, and credential leakage.










