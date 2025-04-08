<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateOne extends Command
{
    protected $signature = 'migrate:one {migration}';
    protected $description = 'Exécute une seule migration spécifique';

    public function handle()
    {
        $migrationName = $this->argument('migration');
        $path = database_path('migrations');
        $files = File::files($path);

        $found = null;

        foreach ($files as $file) {
            if (str_contains($file->getFilename(), $migrationName)) {
                $found = $file->getFilename();
                break;
            }
        }

        if (!$found) {
            $this->error("❌ Aucune migration trouvée contenant '{$migrationName}'");
            return 1;
        }

        $this->info("🔍 Migration trouvée : {$found}");
        Artisan::call('migrate --path=database/migrations/' . $found);
        $this->info(Artisan::output());

        return 0;
    }
}
