<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Committee;
use App\Models\OrganizationUser;

class CommitteePolicy
{
    /**
     * Determine if the user can view any committees.
     * Read access is public, so this always returns true.
     */
    public function viewAny(OrganizationUser|Admin|null $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the committee.
     * Read access is public, so this always returns true.
     */
    public function view(OrganizationUser|Admin|null $user, Committee $committee): bool
    {
        return true;
    }

    /**
     * Determine if the user can create committees.
     * Only admins or organization users with editor permission can create committees.
     */
    public function create(OrganizationUser|Admin|null $user): bool
    {
        if ($user === null) {
            return false;
        }

        // Admins can always create committees
        if ($user instanceof Admin) {
            return true;
        }

        // Only editor organization users can create committees
        if ($user instanceof OrganizationUser) {
            return $user->isEditor();
        }

        return false;
    }

    /**
     * Determine if the user can update the committee.
     * Only admins or organization users with editor permission can update committees.
     */
    public function update(OrganizationUser|Admin|null $user, Committee $committee): bool
    {
        if ($user === null) {
            return false;
        }

        // Admins can update all committees
        if ($user instanceof Admin) {
            return true;
        }

        // Only editor organization users can update committees
        if ($user instanceof OrganizationUser) {
            return $user->isEditor();
        }

        return false;
    }

    /**
     * Determine if the user can delete the committee.
     * Only admins can delete committees.
     */
    public function delete(OrganizationUser|Admin|null $user, Committee $committee): bool
    {
        if ($user === null) {
            return false;
        }

        // Only admins can delete committees
        return $user instanceof Admin;
    }
}
