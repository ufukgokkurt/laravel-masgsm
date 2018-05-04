<?php
/**
 * Created by PhpStorm.
 * User: ufukgokkurt
 * Date: 3.05.2018
 * Time: 18:11
 */

namespace Ufukgokkurt\Masgsm\Facades;


use Illuminate\Support\Facades\Facade;

class Masgsm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'masgsm';
    }


}