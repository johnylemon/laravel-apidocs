<?php

namespace Johnylemon\Apidocs;

class Exporter implements Export
{
    /**
     * Export Apidocs data into an array
     *
     * @param     Johnylemon\Apidocs\Apidocs    $apidocs    apidocs
     * @return    array                                     apidocs data
     */
    public function export(Apidocs $apidocs): array
    {
        $data = collect($apidocs->getRoutes())->map(function($item){
            return $item->data();
        })->all();

        return [
            'info' => config('apidocs.info'),
            'domain' => config('apidocs.domain'),
            'groups' => $apidocs->groups(),
            'endpoints' => $data,
        ];
    }
}
