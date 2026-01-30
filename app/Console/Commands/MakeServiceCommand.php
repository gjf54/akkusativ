<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Full name of service.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom service class.';

    private $serviceName;

    private $serviceNamespace = 'App\Services';

    public function handle()
    {
        $service = Str::of($this->argument('name'))->split('/\//');

        $this->serviceName = $service->pop();

        $service->each(function ($value) {
            $this->serviceNamespace .= "\\" . $value;
        });

        $replacements = [
            '{{ serviceName }}' => $this->serviceName,
            '{{ serviceNamespace }}' => $this->serviceNamespace,
        ];

        $stubFile = resource_path('stubs/services/Service.stub');
        $servicePath = app_path('Services');
        $serviceName = "{$this->argument('name')}.php";

        if (!File::exists($stubFile)) {
            $this->error('Service: stub file does not exist.');
            return;
        }

        $content = File::get($stubFile);

        $content = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $content
        );

        $filePath = "{$servicePath}" . '/' . $serviceName;

        if(File::exists($filePath)) {
            $this->error('Service: ' . $serviceName . ' already exists.');
            return;
        }

        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, $content);

        $this->info("Service {$serviceName} created successfully!");
    }
}
