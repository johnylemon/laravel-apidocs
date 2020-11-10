<?php

namespace Johnylemon\Apidocs\Console\Commands;

class MakeEndpoint extends Make
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidocs:endpoint {name}';

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
        return config('apidocs.dir.endpoints');
    }

    /**
     * @inheritdoc
     */
    protected function stub(): string
    {
        return __DIR__.'/../../../stubs/endpoint.stub';
    }
}
