<?php

namespace App\Providers;

use App\Models\Committee;
use App\Models\OrganizationUser;
use App\Models\Post;
use App\Policies\CommitteePolicy;
use App\Policies\OrganizationUserPolicy;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        OrganizationUser::class => OrganizationUserPolicy::class,
        Committee::class => CommitteePolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(OrganizationUser::class, OrganizationUserPolicy::class);
        Gate::policy(Committee::class, CommitteePolicy::class);
    }
}
