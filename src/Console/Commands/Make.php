<?php

namespace Johnylemon\Apidocs\Console\Commands;

use Illuminate\Console\Command;
use Johnylemon\Apidocs\Providers\ApidocsServiceProvider;

abstract class Make extends Command
{
    /**
     * Target directory
     *
     * @return string
     */
    abstract protected function targetLocation(): string;

    /**
     * Returns stub file path
     *
     * @return    string    stub path
     */
    abstract protected function stub(): string;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //
        // classname
        //
        $class = $this->argument('name');

        //
        // target location
        //
        $dir = $this->targetLocation();

        //
        // target path
        //
        $path = app_path("$dir/$class.php");

        stub($this->stub(), $path, [
            'NAMESPACE' => $this->namespace($dir),
            'NAME' => $class,
        ]);
    }

    /**
     * Prepare namespace for stub class file
     *
     * @param     string    $path    stub directory
     * @return    string             generated namespace
     */
    protected function namespace(string $path): string
    {
        return 'App\\'.str_replace(['/'], ['\\'], $path);
    }
}
