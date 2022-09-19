<?php

namespace App\Http\Controllers;

class ConfigController extends Controller
{
    public function get()
    {
        $configValue = \Config::get('key');

        return $configValue;
    }
}
