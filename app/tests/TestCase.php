<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $hot = public_path('hot');
        if (! file_exists($hot)) {
            file_put_contents($hot, 'http://localhost:5173');
        }
    }

    protected function tearDown(): void
    {
        $hot = public_path('hot');
        if (file_exists($hot)) {
            @unlink($hot);
        }
        parent::tearDown();
    }
}
