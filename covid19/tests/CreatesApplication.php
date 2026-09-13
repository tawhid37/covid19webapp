<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Run the test suite against an in-memory SQLite database so no
        // external database server is required (used by RefreshDatabase).
        $app->config->set('database.default', 'sqlite');
        $app->config->set('database.connections.sqlite.database', ':memory:');

        return $app;
    }
}
