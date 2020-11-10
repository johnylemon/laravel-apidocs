<?php

namespace Johnylemon\Apidocs\Console\Commands;

class MakeParam extends Make
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidocs:param {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Apidocs Endpoint';

    /**
     * @inheritdoc
     */
    protected function targetLocation(): string
    {
        return config('apidocs.dir.params');
    }

    /**
     * @inheritdoc
     */
    protected function stub(): string
    {
        return __DIR__.'/../../../stubs/param.stub';
    }
}
