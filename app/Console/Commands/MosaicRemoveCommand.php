<?php

namespace App\Console\Commands;

use App\Services\ModuleGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MosaicRemoveCommand extends Command
{
    protected $signature = 'mosaic:remove {module : Module name in domain.entity format} {--force : Skip confirmation}';
    protected $description = 'Remove a Mosaic module from the application';

    protected $generator;

    public function __construct(ModuleGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function handle()
    {
        $module = $this->argument('module');

        // Valider le format domain.entity
        if (!str_contains($module, '.')) {
            $this->components->error('Module must be in domain.entity format (e.g., ecommerce.customers)');
            return 1;
        }

        [$domain, $entity] = explode('.', $module);

        if (!$this->option('force')) {
            if (!$this->confirm("Are you sure you want to remove module [{$module}]? This will delete files but NOT drop database tables.")) {
                return 0;
            }
        }

        try {
            $this->components->warn("Removing module [{$module}]...");

            $this->generator->remove($domain, $entity);

            $this->components->success("Module [{$module}] removed successfully!");
            $this->components->warn("Note: Database tables and migrations were NOT removed. Please handle manually if needed.");

            return 0;
        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
            return 1;
        }
    }
}
