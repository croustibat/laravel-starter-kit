<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModuleGenerator
{
    protected $files;
    protected $manifest;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $manifestPath = base_path('stubs/mosaic/module-manifest.json');

        if (!$this->files->exists($manifestPath)) {
            throw new \Exception("Module manifest not found at: {$manifestPath}");
        }

        $this->manifest = json_decode($this->files->get($manifestPath), true);
    }

    public function generate(string $domain, string $entity, bool $withDemoData = true)
    {
        // Vérifier que le module existe dans le manifest
        if (!isset($this->manifest[$domain][$entity])) {
            throw new \Exception("Module {$domain}.{$entity} not found in manifest");
        }

        $config = $this->manifest[$domain][$entity];

        // Générer tous les composants
        $this->generateModel($domain, $entity, $config);
        $this->generateMigration($domain, $entity, $config);
        $this->generateController($domain, $entity, $config);
        $this->generateView($domain, $entity, $config);
        $this->generateTableComponent($domain, $entity, $config);

        if ($withDemoData) {
            $this->generateSeeder($domain, $entity, $config);
            $this->registerSeeder($entity, $config);
        }

        $this->addRouteFile($domain, $entity, $config);
        $this->ensureRouteLoading($domain);
    }

    protected function generateModel($domain, $entity, $config)
    {
        $stub = $this->getStub('model.stub');
        $model = $config['model'];

        // Générer la liste des champs fillable
        $fillableFields = array_map(function($col) {
            return "'{$col['name']}'";
        }, $config['columns']);
        $fillable = implode(",\n        ", $fillableFields);

        $replacements = [
            '{{ domain }}' => Str::studly($domain),
            '{{ model }}' => $model,
            '{{ fillable }}' => $fillable,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $path = app_path("Models/" . Str::studly($domain) . "/{$model}.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $content);
    }

    protected function generateMigration($domain, $entity, $config)
    {
        $stub = $this->getStub('migration.stub');
        $table = $config['table'];

        // Générer les colonnes
        $columnLines = [];
        foreach ($config['columns'] as $col) {
            $line = $this->generateColumnLine($col);
            $columnLines[] = $line;
        }
        $columns = implode("\n            ", $columnLines);

        $replacements = [
            '{{ table }}' => $table,
            '{{ columns }}' => $columns,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $timestamp = date('Y_m_d_His');
        $path = database_path("migrations/{$timestamp}_create_{$table}_table.php");
        $this->files->put($path, $content);
    }

    protected function generateColumnLine($col)
    {
        $type = $col['type'];
        $name = $col['name'];

        $line = "\$table->{$type}('{$name}'";

        // Ajouter la longueur si spécifiée
        if (isset($col['length'])) {
            $line .= ", {$col['length']}";
        }

        $line .= ")";

        // Ajouter nullable si spécifié
        if (isset($col['nullable']) && $col['nullable']) {
            $line .= "->nullable()";
        }

        // Ajouter default si spécifié
        if (isset($col['default'])) {
            $default = is_string($col['default']) ? "'{$col['default']}'" : ($col['default'] ? 'true' : 'false');
            $line .= "->default({$default})";
        }

        $line .= ";";

        return $line;
    }

    protected function generateController($domain, $entity, $config)
    {
        $stub = $this->getStub('controller.stub');
        $model = $config['model'];

        $replacements = [
            '{{ domain }}' => Str::studly($domain),
            '{{ model }}' => $model,
            '{{ variablePlural }}' => Str::plural(Str::camel($entity)),
            '{{ domainLower }}' => Str::kebab($domain),
            '{{ entityLower }}' => Str::kebab($entity),
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $path = app_path("Http/Controllers/" . Str::studly($domain) . "/{$model}Controller.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $content);
    }

    protected function generateView($domain, $entity, $config)
    {
        $stub = $this->getStub('view.stub');

        $replacements = [
            '{{ title }}' => $config['title'] ?? Str::title($entity),
            '{{ domainLower }}' => Str::kebab($domain),
            '{{ entityLower }}' => Str::kebab($entity),
            '{{ variablePlural }}' => Str::plural(Str::camel($entity)),
            '{{ modelSingular }}' => Str::singular(Str::title($entity)),
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $path = resource_path("views/pages/" . Str::kebab($domain) . "/" . Str::kebab($entity) . ".blade.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $content);
    }

    protected function generateTableComponent($domain, $entity, $config)
    {
        $stub = $this->getStub('table-component.stub');

        // Générer les headers
        $headers = [];
        foreach ($config['columns'] as $col) {
            $label = $col['label'] ?? Str::title($col['name']);
            $headers[] = "<th class=\"px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap\">\n                            <div class=\"font-semibold text-left\">{$label}</div>\n                        </th>";
        }
        $tableHeaders = implode("\n                        ", $headers);

        // Générer les colonnes
        $columns = [];
        foreach ($config['columns'] as $col) {
            $columns[] = "<td class=\"px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap\">\n                            <div>{{ \$" . Str::singular(Str::camel($entity)) . "->" . $col['name'] . " }}</div>\n                        </td>";
        }
        $tableColumns = implode("\n                        ", $columns);

        $replacements = [
            '{{ variablePlural }}' => Str::plural(Str::camel($entity)),
            '{{ variableSingular }}' => Str::singular(Str::camel($entity)),
            '{{ modelPlural }}' => Str::plural(Str::title($entity)),
            '{{ tableHeaders }}' => $tableHeaders,
            '{{ tableColumns }}' => $tableColumns,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $path = resource_path("views/components/" . Str::kebab($domain) . "/" . Str::kebab($entity) . "-table.blade.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $content);
    }

    protected function generateSeeder($domain, $entity, $config)
    {
        $stub = $this->getStub('seeder.stub');
        $model = $config['model'];

        // Formater les données de démo
        $demoDataLines = [];
        foreach ($config['demo_data'] as $data) {
            $demoDataLines[] = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $demoData = implode(",\n        ", $demoDataLines);

        $replacements = [
            '{{ domain }}' => Str::studly($domain),
            '{{ model }}' => $model,
            '{{ demoData }}' => $demoData,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $path = database_path("seeders/{$model}Seeder.php");
        $this->files->put($path, $content);
    }

    protected function registerSeeder($entity, $config)
    {
        $seederClass = $config['model'] . 'Seeder::class';
        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');

        if (!$this->files->exists($databaseSeederPath)) {
            throw new \Exception("DatabaseSeeder.php not found");
        }

        $content = $this->files->get($databaseSeederPath);

        // Vérifier si les marqueurs existent
        if (!str_contains($content, '// Mosaic Module Seeders')) {
            // Ajouter les marqueurs dans la méthode run()
            $content = str_replace(
                'public function run(): void',
                "public function run(): void\n    {\n        // Mosaic Module Seeders - DO NOT EDIT THIS SECTION MANUALLY\n        \$this->call([\n        ]);\n        // End Mosaic Module Seeders",
                $content
            );
            // Supprimer l'accolade fermante en trop si elle existe
            $content = preg_replace('/\{\s*\}/', '', $content, 1);
        }

        // Ajouter le seeder dans la section
        $content = str_replace(
            '// Mosaic Module Seeders - DO NOT EDIT THIS SECTION MANUALLY
        $this->call([',
            "// Mosaic Module Seeders - DO NOT EDIT THIS SECTION MANUALLY\n        \$this->call([\n            {$seederClass},",
            $content
        );

        $this->files->put($databaseSeederPath, $content);
    }

    protected function addRouteFile($domain, $entity, $config)
    {
        $model = $config['model'];
        $domainKebab = Str::kebab($domain);
        $entityKebab = Str::kebab($entity);
        $domainStudly = Str::studly($domain);

        $routeFilePath = base_path("routes/domains/{$domainKebab}.php");

        $routeLine = "    Route::get('/{$entityKebab}', [{$model}Controller::class, 'index'])->name('{$domainKebab}.{$entityKebab}');\n";

        if ($this->files->exists($routeFilePath)) {
            // Ajouter la route au fichier existant
            $content = $this->files->get($routeFilePath);

            // Ajouter l'import du controller si pas déjà présent
            $useStatement = "use App\\Http\\Controllers\\{$domainStudly}\\{$model}Controller;";
            if (!str_contains($content, $useStatement)) {
                // Ajouter après les autres use statements
                $content = preg_replace(
                    '/(use [^;]+;)(\s+use Illuminate)/',
                    "$1\n{$useStatement}$2",
                    $content
                );
            }

            // Ajouter avant la dernière accolade fermante
            $content = preg_replace('/}\);$/', $routeLine . '});', $content);
            $this->files->put($routeFilePath, $content);
        } else {
            // Créer un nouveau fichier de routes
            $content = "<?php\n\n";
            $content .= "use App\\Http\\Controllers\\{$domainStudly}\\{$model}Controller;\n";
            $content .= "use Illuminate\\Support\\Facades\\Route;\n\n";
            $content .= "Route::prefix('{$domainKebab}')->middleware(['auth'])->group(function () {\n";
            $content .= $routeLine;
            $content .= "});\n";

            $this->ensureDirectoryExists(dirname($routeFilePath));
            $this->files->put($routeFilePath, $content);
        }
    }

    protected function ensureRouteLoading($domain)
    {
        $domainKebab = Str::kebab($domain);
        $webRoutesPath = base_path('routes/web.php');
        $content = $this->files->get($webRoutesPath);

        $requireLine = "if (file_exists(__DIR__.'/domains/{$domainKebab}.php')) {\n    require __DIR__.'/domains/{$domainKebab}.php';\n}";

        // Vérifier si le chargement existe déjà
        if (str_contains($content, "domains/{$domainKebab}.php")) {
            return; // Déjà chargé
        }

        // Vérifier si la section Mosaic existe
        if (!str_contains($content, '// Mosaic Module Routes')) {
            // Ajouter la section à la fin du fichier
            $content .= "\n\n// Mosaic Module Routes - DO NOT EDIT THIS SECTION MANUALLY\n";
            $content .= $requireLine . "\n";
            $content .= "// End Mosaic Module Routes\n";
        } else {
            // Ajouter dans la section existante
            $content = str_replace(
                '// End Mosaic Module Routes',
                $requireLine . "\n// End Mosaic Module Routes",
                $content
            );
        }

        $this->files->put($webRoutesPath, $content);
    }

    protected function getStub($name)
    {
        $path = base_path("stubs/mosaic/{$name}");

        if (!$this->files->exists($path)) {
            throw new \Exception("Stub file not found: {$path}");
        }

        return $this->files->get($path);
    }

    protected function ensureDirectoryExists($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true, true);
        }
    }

    public function remove(string $domain, string $entity)
    {
        // Vérifier que le module existe dans le manifest
        if (!isset($this->manifest[$domain][$entity])) {
            throw new \Exception("Module {$domain}.{$entity} not found in manifest");
        }

        $config = $this->manifest[$domain][$entity];
        $model = $config['model'];
        $domainStudly = Str::studly($domain);
        $domainKebab = Str::kebab($domain);
        $entityKebab = Str::kebab($entity);

        // Supprimer les fichiers
        $this->removeFile(app_path("Models/{$domainStudly}/{$model}.php"));
        $this->removeFile(app_path("Http/Controllers/{$domainStudly}/{$model}Controller.php"));
        $this->removeFile(resource_path("views/pages/{$domainKebab}/{$entityKebab}.blade.php"));
        $this->removeFile(resource_path("views/components/{$domainKebab}/{$entityKebab}-table.blade.php"));
        $this->removeFile(database_path("seeders/{$model}Seeder.php"));

        // Supprimer du DatabaseSeeder
        $this->unregisterSeeder($model);

        // Supprimer la route du fichier de domaine
        $this->removeRoute($domain, $entity);
    }

    protected function removeFile($path)
    {
        if ($this->files->exists($path)) {
            $this->files->delete($path);
        }
    }

    protected function unregisterSeeder($model)
    {
        $seederClass = $model . 'Seeder::class';
        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');

        if (!$this->files->exists($databaseSeederPath)) {
            return;
        }

        $content = $this->files->get($databaseSeederPath);

        // Supprimer la ligne du seeder
        $content = preg_replace("/\s*{$seederClass},?\n/", "", $content);

        $this->files->put($databaseSeederPath, $content);
    }

    protected function removeRoute($domain, $entity)
    {
        $domainKebab = Str::kebab($domain);
        $entityKebab = Str::kebab($entity);
        $routeFilePath = base_path("routes/domains/{$domainKebab}.php");

        if (!$this->files->exists($routeFilePath)) {
            return;
        }

        $content = $this->files->get($routeFilePath);

        // Supprimer la ligne de route
        $content = preg_replace("/\s*Route::get\('\/{$entityKebab}'.*\n/", "", $content);

        // Si le fichier ne contient plus de routes, le supprimer
        if (preg_match('/group\(function \(\) \{\s*}\);/', $content)) {
            $this->files->delete($routeFilePath);

            // Supprimer le require de web.php
            $webRoutesPath = base_path('routes/web.php');
            $webContent = $this->files->get($webRoutesPath);
            $webContent = preg_replace("/if \(file_exists\(__DIR__\.'\/domains\/{$domainKebab}\.php'\)\) \{\s*require __DIR__\.'\/domains\/{$domainKebab}\.php';\s*}\n/", "", $webContent);
            $this->files->put($webRoutesPath, $webContent);
        } else {
            $this->files->put($routeFilePath, $content);
        }
    }
}
