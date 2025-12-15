<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrganizationUser extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\OrganizationUserFactory> */
    use HasFactory, Notifiable;

    public const PERMISSION_VIEWER = 'viewer';
    public const PERMISSION_EDITOR = 'editor';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'committee_id',
        'permission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if the organization user is an editor.
     */
    public function isEditor(): bool
    {
        return $this->permission === self::PERMISSION_EDITOR;
    }

    /**
     * Determine if the organization user is a viewer.
     */
    public function isViewer(): bool
    {
        return $this->permission === self::PERMISSION_VIEWER;
    }

    /**
     * Get the committee that the organization user belongs to.
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Get the posts for the organization user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
