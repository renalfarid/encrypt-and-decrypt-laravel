<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $interfaceFolder = 'App\Interfaces';

    protected $repositoryFolder = 'App\Repositories';

    private function isFilesExists($interface)
    {

        if (!file_exists(base_path("app/Interfaces/{$interface}Interface.php"))) return false;

        if (!file_exists(base_path("app/Repositories/{$interface}Repository.php"))) return false;

        return true;
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $interfaces = [
            'Auth',
            'Users'
        ];
        if (count($interfaces)) {
            foreach ($interfaces as $key => $interface) {
                if ($this->isFilesExists($interface)) $this->app->bind("{$this->interfaceFolder}\\{$interface}Interface", "{$this->repositoryFolder}\\{$interface}Repository");
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
