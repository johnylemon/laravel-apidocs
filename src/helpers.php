<?php

use Johnylemon\Apidocs\Facades\Apidocs;

/**
 * Define defered Apidocs definitions
 *
 * @param     array     $definitions
 */
function apidocs(array $definitions)
{
    Apidocs::defer($definitions);
}
