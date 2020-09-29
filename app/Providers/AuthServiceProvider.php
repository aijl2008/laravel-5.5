<?php

namespace App\Providers;

use App\Models\Rbac\Menu;
use App\Models\Rbac\Navigation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        view()->composer('*', function ($view) {
            $navigation = new Collection();
            $user = request()->user();
            if ($user) {
                foreach ((new Menu())->parent(0)->get() as $item) {
                    if ($user->hasPermission($item->real_url)) {
                        $obj = new Navigation([
                            'name' => $item->name,
                            'target' => $item->target,
                            'url' => $item->real_url
                        ]);
                        if ($item->hasChildren()) {
                            foreach ($item->children() as $child) {
                                if ($user->hasPermission($child->real_url)) {
                                    $obj->children[]=(new Navigation([
                                        'name' => $child->name,
                                        'target' => $child->target,
                                        'url' => $child->real_url
                                    ]));
                                }
                            }
                        }
                        $navigation->add($obj);
                    }
                }
            }
            $view->with('navigation', $navigation);
        });
    }
}
