<?php

namespace Modules\PageBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Modules\PageBuilder\Contracts\ContentReadTimeResolver;
use Modules\PageBuilder\Nova\Resources\Content;
use Modules\PageBuilder\Observers\ContentObserver;
use Modules\PageBuilder\Resolvers\DefaultContentReadTimeResolver;
use Modules\PageBuilder\Services\PageBuilderService;

class PageBuilderServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected string $moduleName = 'PageBuilder';

    /**
     * @var string
     */
    protected string $moduleNameLower = 'page-builder';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        Nova::resources([
            Content::class,
        ]);

        \Modules\PageBuilder\Models\Content::observe(ContentObserver::class);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ContentReadTimeResolver::class, DefaultContentReadTimeResolver::class);
        $this->app->singleton(
            PageBuilderService::class,
            fn () => new PageBuilderService(config($this->moduleNameLower, []))
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PageBuilderService::class];
    }
}
