<?php

namespace Kjjdion\Laracrud\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Crud extends Command
{
    protected $signature = 'make:crud {role} {model}';
    protected $description = 'Generate role model CRUD.';
    protected $files;
    protected $replaces = [];
    protected $stubs_path = __DIR__ . '/../../../resources/stubs/crud';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        // use laravel file system
        $this->files = $files;
    }

    public function handle()
    {
        // set class values
        $this->setReplaces();

        // generate crud
        $this->line('Generating <info>' . $this->argument('model') . '</info> CRUD...');
        $this->createControllerFile();
        $this->createModelFile();
        $this->createMigrationFile();
        $this->createViewFiles();
        $this->insertNavItem();
        $this->insertRoutes();
        $this->line('CRUD generation for <info>' . $this->argument('model') . '</info> complete!');
    }

    public function setReplaces()
    {
        $this->replaces = [
            // replace role values
            '{role_string}' => $role_string = $this->argument('role'),
            '{role_strings}' => $role_strings = Str::plural($role_string),
            '{role_class}' => str_replace(' ', '', $role_string),
            '{role_classes}' => str_replace(' ', '', $role_strings),
            '{role_variable}' => Str::snake($role_string),
            '{role_variables}' => Str::snake($role_strings),

            // replace model values
            '{model_string}' => $model_string = $this->argument('model'),
            '{model_strings}' => $model_strings = Str::plural($model_string),
            '{model_class}' => str_replace(' ', '', $model_string),
            '{model_classes}' => str_replace(' ', '', $model_strings),
            '{model_variable}' => Str::snake($model_string),
            '{model_variables}' => Str::snake($model_strings),
        ];
    }

    public function replace($content)
    {
        // replace all occurrences with $this->replaces
        foreach ($this->replaces as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        return $content;
    }

    public function createControllerFile()
    {
        // create controller directory if it doesn't already exist
        $controller_path = app_path('Http/Controllers/' . $this->replaces['{role_class}']);
        if (!$this->files->exists($controller_path)) {
            $this->files->makeDirectory($controller_path, 0755, true);
        }

        // create controller file
        $controller_file = $controller_path . '/' . $this->replaces['{model_class}'] . 'Controller.php';

        // make sure controller file does not exist
        if ($this->files->exists($controller_file)) {
            $this->warn('Controller file exists: <info>' . $controller_file . '</info>');
            return;
        }

        $controller_stub = $this->files->get($this->stubs_path . '/controller.stub');
        $this->files->put($controller_file, $this->replace($controller_stub));
        $this->line('Controller file created: <info>' . $controller_file . '</info>');
    }

    public function createModelFile()
    {
        // create model file
        $model_file = app_path($this->replaces['{model_class}'] . '.php');

        // make sure model file does not exist
        if ($this->files->exists($model_file)) {
            $this->warn('Model file exists: <info>' . $model_file . '</info>');
            return;
        }

        $model_stub = $this->files->get($this->stubs_path . '/model.stub');
        $this->files->put($model_file, $this->replace($model_stub));
        $this->line('Model file created: <info>' . $model_file . '</info>');
    }

    public function createMigrationFile()
    {
        // create migration file
        $migrations_name = '_create_' . $this->replaces['{model_variables}'] . '_table.php';
        $existing_files = glob(database_path('migrations/*' . $migrations_name));

        // make sure migration file does not exist
        if (!empty($existing_files)) {
            $this->warn('Migration file exists: <info>' . $migrations_name . '</info>');
            return;
        }

        $migrations_file = database_path('migrations/' . date('Y_m_d_His') . $migrations_name);
        $migrations_stub = $this->files->get($this->stubs_path . '/migration.stub');
        $this->files->put($migrations_file, $this->replace($migrations_stub));
        $this->line('Migration file created: <info>' . $migrations_file . '</info>');
    }

    public function createViewFiles()
    {
        // create view directory if it doesn't already exist
        $view_path = resource_path('views/' . $this->replaces['{role_variable}'] . '/' . $this->replaces['{model_variables}']);
        if (!$this->files->exists($view_path . '/datatables')) {
            $this->files->makeDirectory($view_path . '/datatables', 0755, true);
        }

        // create view files
        foreach ($this->files->allFiles($this->stubs_path . '/views/models') as $file) {
            $new_file = $view_path . '/' . ltrim($file->getRelativePath() . '/' . str_replace('.stub', '.blade.php', $file->getFilename()), '/');

            // make sure view file does not exist
            if ($this->files->exists($new_file)) {
                $this->warn('View files exist: <info>' . $view_path . '/*.*</info>');
                return;
            }

            $this->files->put($new_file, $this->replace($file->getContents()));
        }

        $this->line('View files created: <info>' . $view_path . '/*.*</info>');
    }

    public function insertNavItem()
    {
        // insert nav item
        $nav_path = resource_path('views/vendor/laracrud/layouts/nav.blade.php');
        $nav_file = $this->files->get($nav_path);
        $nav_stub = $this->files->get($this->stubs_path . '/views/nav.stub');
        $nav_content = $this->replace($nav_stub);
        $search = "@can('" . $this->replaces['{role_string}'] . "')";

        // make sure nav item does not exist
        if (strpos($nav_file, $nav_content) !== false) {
            $this->warn('Nav item exists: <info>' . $nav_path . '</info>');
            return;
        }

        if (strpos($nav_file, $search) === false) {
            // @can('Role') does not exist, append nav item with it
            $this->files->append($nav_path, PHP_EOL . PHP_EOL . $search . PHP_EOL . $nav_content . PHP_EOL . '@endcan');
            $this->line('Nav item appended: <info>' . $nav_path . '</info>');
        }
        else {
            // @can('Role') exists, insert nav item after
            $index = strpos($nav_file, $search);
            $this->files->put($nav_path, substr_replace($nav_file, $search . PHP_EOL . $nav_content, $index, strlen($search)));
            $this->line('Nav item inserted: <info>' . $nav_path . '</info>');
        }
    }

    public function insertRoutes()
    {
        // insert routes
        $routes_path = base_path('routes/web.php');
        $routes_file = $this->files->get($routes_path);
        $routes_stub = $this->files->get($this->stubs_path . '/routes.stub');
        $routes_content = PHP_EOL . PHP_EOL . $this->replace($routes_stub);

        // make sure routes do not exist
        if (strpos($routes_file, $routes_content) !== false) {
            $this->warn('Routes exist: <info>' . $routes_path . '</info>');
            return;
        }

        $this->files->append($routes_path, $routes_content);
        $this->line('Routes inserted: <info>' . $routes_path . '</info>');
    }
}