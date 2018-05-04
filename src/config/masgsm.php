<?php

/**
 * Laravel 5 Masgsm SMS
 * @license MIT License
 * @author Ufuk GÖKKURT <ufuk.gokkurt@gmail.com>
 * @link http://ufukgokkurt.com
 *
 */
return [

    // Masgsm user and pass

    'user'=>env('MASGSM_USER', ''),
    'pass'=>env('MASGSM_PASS', ''),


    //Default SMS Title

    'title'=>env('MASGSM_DEFAULT_TITLE', ''),

    //Masgsm API URL
    'apiUrl'=>'http://masgsm.com.tr/MasApiV2/'

];