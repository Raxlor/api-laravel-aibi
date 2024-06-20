<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class GenerateSwaggerDocs extends Command
{
    protected $signature = 'swagger:generate';
    protected $description = 'Generate Swagger documentation';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $swagger = Generator::scan(config('swagger.scan'));
        $output = config('swagger.output') . '/swagger.json';

        if (!is_dir(dirname($output))) {
            mkdir(dirname($output), 0755, true);
        }

        file_put_contents($output, $swagger->toJson());
        $this->info('Swagger documentation generated successfully.');
    }
}
