<?php

declare(strict_types=1);

namespace Http\Controllers;

use Tests\TestCase;

class ConfigControllerTest extends TestCase
{
    public function testGet()
    {
        \Illuminate\Support\Facades\Config::shouldReceive('get')->once()->with('key')->andReturn('value');
        $this->get(route('config.get'));
    }
}
