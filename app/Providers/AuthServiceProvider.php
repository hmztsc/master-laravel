<?php

namespace App\Providers;

use App\Policies\BlogPostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function ($user){
            return $user->is_admin;
        });

        // 1.method
        // Gate::define('update-post', function($user, $post){
        //     return $user->id === $post->id;
        // });

        // Gate::define('delete-post', function($user, $post){
        //     return $user->id === $post->id;
        // });

        // 2.method
        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // OR
        // Gate::define('posts.update', [BlogPostPolicy::class, 'delete']);

        // 3.method
        // Gate::resource('posts', BlogPostPolicy::class);

        Gate::before(function($user, $ability){
            if($user->is_admin && in_array($ability, ['create', 'delete', 'update'])){
                return true;
            }
        });

        // Gate::after(function($user){
        //     if($user->is_admin){
        //         return true;
        //     }
        // });
    }
}
