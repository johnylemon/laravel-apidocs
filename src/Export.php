<?php

namespace Johnylemon\Apidocs;

interface Export
{
    /**
     * Export Apidocs data into an array
     *
     * @param     Johnylemon\Apidocs\Apidocs    $apidocs    apidocs
     * @return    array                                     apidocs data
     */
    public function export(Apidocs $apidocs): array;
}
