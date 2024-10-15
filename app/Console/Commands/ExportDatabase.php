<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabase extends Command
{
    // El nombre y la firma del comando (lo que escribirás en la terminal para ejecutarlo)
    protected $signature = 'db:export';

    // La descripción del comando
    protected $description = 'Exportar la base de datos a un archivo SQL';

    // El método que ejecuta el comando
    public function handle()
    {
        // Aquí puedes configurar tu base de datos, archivo de salida y credenciales
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $outputPath = storage_path('app/' . $dbName . '_backup.sql'); // Carpeta de storage

        // Comando mysqldump
        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$outputPath}";

        // Ejecutar el comando mysqldump
        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Base de datos exportada correctamente a {$outputPath}");
        } else {
            $this->error('Error al exportar la base de datos.');
        }
    }
}
