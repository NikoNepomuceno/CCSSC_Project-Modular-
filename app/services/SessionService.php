<?php

namespace App\Services;

use App\Models\AuthSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SessionService
{
    /**
     * Generate a secure random refresh token (64 random bytes → 128 hex chars)
     */
    public function generateRefreshToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    /**
     * Hash token with SHA-256 + HMAC using app key as secret
     */
    public function hashToken(string $token): string
    {
        return hash_hmac('sha256', $token, config('app.key'));
    }

    /**
     * Create a new session for a user
     */
    public function createSession(
        Model $user,
        string $ipAddress,
        string $userAgent,
        int $absoluteExpiryDays = 30,
        int $inactivityMinutes = 60
    ): array {
        $refreshToken = $this->generateRefreshToken();
        $csrfToken = bin2hex(random_bytes(32));

        $session = AuthSession::create([
            'id' => Str::uuid(),
            'authenticatable_type' => get_class($user),
            'authenticatable_id' => $user->id,
            'refresh_token_hash' => $this->hashToken($refreshToken),
            'csrf_token_hash' => $this->hashToken($csrfToken),
            'expires_at' => now()->addDays($absoluteExpiryDays),
            'last_activity_at' => now(),
            'inactivity_timeout_minutes' => $inactivityMinutes,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'device_name' => $this->parseDeviceName($userAgent),
        ]);

        return [
            'session' => $session,
            'refresh_token' => $refreshToken,
            'csrf_token' => $csrfToken,
        ];
    }

    /**
     * Validate refresh token and rotate it (issue new token, invalidate old)
     * Returns null if token is invalid, expired, or reused (security breach)
     */
    public function rotateToken(string $refreshToken): ?array
    {
        $hash = $this->hashToken($refreshToken);

        // Check current token
        $session = AuthSession::where('refresh_token_hash', $hash)
            ->where('is_revoked', false)
            ->first();

        if (!$session) {
            // Check if it's a reused old token (security breach!)
            $compromised = AuthSession::where('previous_token_hash', $hash)->first();
            if ($compromised) {
                // Revoke entire session - token was stolen and reused
                $compromised->update([
                    'is_revoked' => true,
                    'revoked_at' => now(),
                    'revoke_reason' => 'token_reuse_detected',
                ]);
            }
            return null;
        }

        // Check absolute expiry
        if ($session->expires_at < now()) {
            return null;
        }

        // Check inactivity timeout
        $lastActivity = $session->last_activity_at?->copy();

        if (!$lastActivity) {
            return null;
        }

        $inactiveThreshold = $lastActivity->addMinutes($session->inactivity_timeout_minutes);
        if ($inactiveThreshold < now()) {
            return null;
        }

        // Rotate token - store old hash for reuse detection
        $newToken = $this->generateRefreshToken();
        $session->update([
            'previous_token_hash' => $session->refresh_token_hash,
            'refresh_token_hash' => $this->hashToken($newToken),
            'last_activity_at' => now(),
            'last_rotated_at' => now(),
            'rotation_count' => $session->rotation_count + 1,
        ]);

        return [
            'session' => $session->fresh(),
            'refresh_token' => $newToken,
        ];
    }

    /**
     * Find session by refresh token hash
     */
    public function findByRefreshToken(string $refreshToken): ?AuthSession
    {
        $hash = $this->hashToken($refreshToken);

        return AuthSession::where('refresh_token_hash', $hash)
            ->where('is_revoked', false)
            ->first();
    }

    /**
     * Parse user agent string to a friendly device name
     */
    private function parseDeviceName(string $userAgent): string
    {
        if (str_contains($userAgent, 'Windows')) {
            return 'Windows PC';
        }
        if (str_contains($userAgent, 'Macintosh')) {
            return 'Mac';
        }
        if (str_contains($userAgent, 'iPhone')) {
            return 'iPhone';
        }
        if (str_contains($userAgent, 'iPad')) {
            return 'iPad';
        }
        if (str_contains($userAgent, 'Android')) {
            return 'Android Device';
        }
        if (str_contains($userAgent, 'Linux')) {
            return 'Linux PC';
        }
        return 'Unknown Device';
    }

    /**
     * Revoke a single session
     */
    public function revokeSession(AuthSession $session, string $reason = 'logout'): void
    {
        $session->update([
            'is_revoked' => true,
            'revoked_at' => now(),
            'revoke_reason' => $reason,
        ]);
    }

    /**
     * Revoke all sessions for a user, optionally except one
     */
    public function revokeAllUserSessions(Model $user, ?string $exceptSessionId = null): void
    {
        $query = AuthSession::where('authenticatable_type', get_class($user))
            ->where('authenticatable_id', $user->id)
            ->where('is_revoked', false);

        if ($exceptSessionId) {
            $query->where('id', '!=', $exceptSessionId);
        }

        $query->update([
            'is_revoked' => true,
            'revoked_at' => now(),
            'revoke_reason' => 'security_logout_all',
        ]);
    }

    /**
     * Get all active sessions for a user
     */
    public function getUserSessions(Model $user): \Illuminate\Database\Eloquent\Collection
    {
        return AuthSession::where('authenticatable_type', get_class($user))
            ->where('authenticatable_id', $user->id)
            ->where('is_revoked', false)
            ->where('expires_at', '>', now())
            ->orderBy('last_activity_at', 'desc')
            ->get();
    }

    /**
     * Update session activity timestamp (for sliding expiry)
     */
    public function touchSession(AuthSession $session): void
    {
        $session->update([
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Validate CSRF token for a session
     */
    public function validateCsrfToken(AuthSession $session, string $csrfToken): bool
    {
        return hash_equals($session->csrf_token_hash, $this->hashToken($csrfToken));
    }
}
