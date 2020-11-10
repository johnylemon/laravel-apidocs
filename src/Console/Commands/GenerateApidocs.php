<?php

namespace Johnylemon\Apidocs\Console\Commands;

use Illuminate\Console\Command;
use Johnylemon\Apidocs\Facades\Apidocs;

class GenerateApidocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidocs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates API documentation';

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
        $data = Apidocs::export();

        file_put_contents(config('apidocs.file_path'), json_encode($data));
    }
}
