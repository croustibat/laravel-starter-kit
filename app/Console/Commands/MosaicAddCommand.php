<?php

namespace App\Console\Commands;

use App\Services\ModuleGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MosaicAddCommand extends Command
{
    protected $signature = 'mosaic:add {module : Module name in domain.entity format} {--empty : Skip demo data}';
    protected $description = 'Add a new Mosaic module to the application';

    protected $generator;

    public function __construct(ModuleGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function handle()
    {
        $module = $this->argument('module');
        $isEmpty = $this->option('empty');

        // Valider le format domain.entity
        if (!str_contains($module, '.')) {
            $this->components->error('Module must be in domain.entity format (e.g., ecommerce.customers)');
            return 1;
        }

        [$domain, $entity] = explode('.', $module);

        try {
            $this->components->info("Adding module [{$module}]...");

            $this->generator->generate($domain, $entity, !$isEmpty);

            $this->components->success("Module [{$module}] created successfully!");
            $this->newLine();
            $this->line("Next steps:");
            $this->line("  • Run: php artisan migrate");
            if (!$isEmpty) {
                $entityStudly = Str::studly($entity);
                $this->line("  • Run: php artisan db:seed --class={$entityStudly}Seeder");
            }
            $this->line("  • Visit: /" . Str::kebab($domain) . "/" . Str::kebab($entity));

            return 0;
        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
            return 1;
        }
    }
}
