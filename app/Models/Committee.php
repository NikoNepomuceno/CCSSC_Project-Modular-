<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{
    use HasFactory;

    /**
     * Predefined committee names.
     */
    public const RAVENS = 'Ravens - RND';
    public const HERONS = 'Herons - CommEX';
    public const CANARY = 'Canary - Creatives';
    public const NIGHTINGALE = 'Nightingale - Broadcasting';
    public const FALCONS = 'Falcons - Events';

    /**
     * Get the default committees with their values.
     *
     * @return list<array{name: string, description: string|null}>
     */
    public static function defaultCommittees(): array
    {
        return [
            ['name' => self::RAVENS, 'description' => null],
            ['name' => self::HERONS, 'description' => null],
            ['name' => self::CANARY, 'description' => null],
            ['name' => self::NIGHTINGALE, 'description' => null],
            ['name' => self::FALCONS, 'description' => null],
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'logo',
    ];

    /**
     * Get the organization users for the committee.
     */
    public function organizationUsers(): HasMany
    {
        return $this->hasMany(OrganizationUser::class);
    }
}
