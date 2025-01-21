<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService
{
    /**
     * Register a new user and generate their unique link.
     */
    public function registerUser(string $username, string $phoneNumber): string
    {
        $uniqueLink = $this->generateUniqueLink();
        $expiresAt = $this->calculateExpirationDate();

        User::create([
            'username' => $username,
            'phone_number' => $phoneNumber,
            'unique_link' => $uniqueLink,
            'link_expires_at' => $expiresAt,
        ]);

        return $uniqueLink;
    }

    /**
     * Generate a new unique link for existing user.
     */
    public function generateNewLink(string $userId): string
    {
        $uniqueLink = $this->generateUniqueLink();
        $expiresAt = $this->calculateExpirationDate();

        $user = User::findOrFail($userId);
        $user->update([
            'unique_link' => $uniqueLink,
            'link_expires_at' => $expiresAt,
        ]);

        return $uniqueLink;
    }

    /**
     * Deactivate user's current link by setting expiration to now.
     */
    public function deactivateLink(string $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'link_expires_at' => Carbon::now(),
        ]);
    }

    /**
     * Get user by ID.
     */
    public function getUser(string $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * Get user by their unique link.
     */
    public function getUserByLink(string $uniqueLink): ?User
    {
        return User::where('unique_link', $uniqueLink)->first();
    }

    /**
     * Check if user's link is expired.
     */
    public function isLinkExpired(User $user): bool
    {
        return $user->link_expires_at->isPast();
    }

    /**
     * Generate a new unique link with verification.
     */
    private function generateUniqueLink(): string
    {
        do {
            $uniqueLink = Str::random(32);
        } while (User::where('unique_link', $uniqueLink)->exists());

        return $uniqueLink;
    }

    /**
     * Calculate expiration date (7 days from now).
     */
    private function calculateExpirationDate(): Carbon
    {
        return Carbon::now()->addDays(7);
    }
}
