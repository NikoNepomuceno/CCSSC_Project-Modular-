<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\OrganizationUser;
use App\Models\Post;

class PostPolicy
{
    /**
     * Determine if the user can view any posts.
     * Read access is public, so this always returns true.
     */
    public function viewAny(OrganizationUser|Admin|null $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the post.
     * Read access is public, so this always returns true.
     */
    public function view(OrganizationUser|Admin|null $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine if the user can create posts.
     * Only editors (organization users with editor permission) or admins can create posts.
     */
    public function create(OrganizationUser|Admin|null $user): bool
    {
        if ($user === null) {
            return false;
        }

        // Admins can always create posts
        if ($user instanceof Admin) {
            return true;
        }

        // Only editor organization users can create posts
        if ($user instanceof OrganizationUser) {
            return $user->isEditor();
        }

        return false;
    }

    /**
     * Determine if the user can update the post.
     * Organization users may only update their own posts.
     * Admins may update all posts.
     */
    public function update(OrganizationUser|Admin|null $user, Post $post): bool
    {
        if ($user === null) {
            return false;
        }

        // Admins can update all posts
        if ($user instanceof Admin) {
            return true;
        }

        // Organization users can only update their own posts if they are editors
        if ($user instanceof OrganizationUser) {
            return $user->isEditor() && $user->id === $post->organization_user_id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the post.
     * Organization users may only delete their own posts.
     * Admins may delete all posts.
     */
    public function delete(OrganizationUser|Admin|null $user, Post $post): bool
    {
        if ($user === null) {
            return false;
        }

        // Admins can delete all posts
        if ($user instanceof Admin) {
            return true;
        }

        // Organization users can only delete their own posts if they are editors
        if ($user instanceof OrganizationUser) {
            return $user->isEditor() && $user->id === $post->organization_user_id;
        }

        return false;
    }
}
