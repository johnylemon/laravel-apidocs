<?php

namespace Johnylemon\Apidocs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class Apidocs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->fromApiDocs($request))
            return $next($request);

        //
        // set queue to sync
        // just to be sure nothing left unfinished
        //
        config(['queue.default' => 'sync']);

        //
        // wrap entire request within transaction
        // to be sure that nothing will be left modified
        //
        DB::beginTransaction();
        $response = $next($request);
        DB::rollBack();

        return $response;
    }

    protected function fromApiDocs(Request $request)
    {
        return $request->headers->get(config('apidocs.header_name'));
    }
}
