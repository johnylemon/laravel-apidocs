<?php

namespace Johnylemon\Apidocs\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Johnylemon\Apidocs\Providers\ApidocsServiceProvider;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidocs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs apidocs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => ApidocsServiceProvider::class,
            '--force' => TRUE,
        ]);

        app(Filesystem::class)->copyDirectory(
           __DIR__.'/../../../publish/assets',
           public_path('vendor/apidocs'),
       );
    }
}
