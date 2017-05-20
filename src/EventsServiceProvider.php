<?php

namespace Laralum\Events;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laralum\Events\Models\Event;
use Laralum\Events\Models\Settings;
use Laralum\Events\Policies\EventPolicy;
use Laralum\Events\Policies\SettingsPolicy;
use Laralum\Permissions\PermissionsChecker;

class EventsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Event::class    => EventPolicy::class,
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Events Access',
            'slug' => 'laralum::events.access',
            'desc' => 'Grants access to events',
        ],
        [
            'name' => 'Create Events',
            'slug' => 'laralum::events.create',
            'desc' => 'Allows creating events',
        ],
        [
            'name' => 'Update Events Categories',
            'slug' => 'laralum::events.update',
            'desc' => 'Allows updating events',
        ],
        [
            'name' => 'View Events Categories',
            'slug' => 'laralum::events.categories.view',
            'desc' => 'Allows view events',
        ],
        [
            'name' => 'Delete Events',
            'slug' => 'laralum::events.delete',
            'desc' => 'Allows deleting events',
        ],
        [
            'name' => 'Publish Events',
            'slug' => 'laralum::events.publish',
            'desc' => 'Allows publishing events',
        ],
        [
            'name' => 'Join Events',
            'slug' => 'laralum::events.join',
            'desc' => 'Allows joining events',
        ],
        [
            'name' => 'Update Events Settings',
            'slug' => 'laralum::events.settings',
            'desc' => 'Allows updating events settings',
        ],
        [
            'name' => 'Events Access (public)',
            'slug' => 'laralum::events.access-public',
            'desc' => 'Grants access to events',
        ],
        [
            'name' => 'Create Events (public)',
            'slug' => 'laralum::events.create-public',
            'desc' => 'Allows creating events',
        ],
        [
            'name' => 'Update Events Categories (public)',
            'slug' => 'laralum::events.update-public',
            'desc' => 'Allows updating events',
        ],
        [
            'name' => 'View Events Categories (public)',
            'slug' => 'laralum::events.categories.view-public',
            'desc' => 'Allows view events',
        ],
        [
            'name' => 'Delete Events (public)',
            'slug' => 'laralum::events.delete-public',
            'desc' => 'Allows deleting events',
        ],
        [
            'name' => 'Publish Events (public)',
            'slug' => 'laralum::events.publish-public',
            'desc' => 'Allows publishing events',
        ],
        [
            'name' => 'Join Events (public)',
            'slug' => 'laralum::events.join-public',
            'desc' => 'Allows joining events',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->publishes([
            __DIR__.'/Views/public' => resource_path('views/vendor/laralum_events/public'),
        ], 'laralum_events');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_events');

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_events');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->app->register('GrahamCampbell\\Markdown\\MarkdownServiceProvider');

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
