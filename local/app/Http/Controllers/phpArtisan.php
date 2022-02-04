<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class phpArtisan extends Controller
{

    public function rsp($namecontroller, $path)
    {
        Artisan::call('make:controller', [
            'name' => $path.'/'.$namecontroller,
            '--resource' => true,
        ]);
    }

    public function rs($namecontroller)
    {
        Artisan::call('make:controller', [
            'name' => $namecontroller,
            '--resource' => true,
        ]);
    }

    public function ctrl($namecontroller)
    {
        Artisan::call('make:controller', [
            'name' => $namecontroller,
        ]);
    }

    public function rq($namecontroller)
    {
        Artisan::call('make:request', [
            'name' => $namecontroller,
        ]);
    }

    public function ctrlp($namecontroller, $path)
    {
        Artisan::call('make:controller', [
            'name' => $path.'/'.$namecontroller,
        ]);
    }

    public function mdl($namecontroller)
    {
        Artisan::call('make:model', [
            'name' => $namecontroller,
        ]);
    }

    public function mg($namecontroller)
    {
        Artisan::call('make:migration', [
            'name' => $namecontroller,
        ]);
    }

    public function runmg()
    {
        Artisan::call('migrate', [
            '--force' => true
        ]);
    }

}
