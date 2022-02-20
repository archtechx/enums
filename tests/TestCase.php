<?php

namespace ArchTech\REPLACE\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;
use ArchTech\REPLACE\REPLACEServiceProvider;

class TestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            REPLACEServiceProvider::class,
        ];
    }
}
