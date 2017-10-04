<?php

/*
 * This file is part of Laravel Vimeo.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'client_id' => '283025b5912b7dae7c8d9a6a2c365bb02fea83d9',
            'client_secret' => 'QAL8oY6lHKLEBlhE1c8kr3YMcCRI48pCZZCtEtXONsivYacGoySm2o8EoAjkWt5cv2UxtR5WvQ9GNhckKLkOGfGVksRnSbTECzL+5sqIks3CpL8UckIw7uktSkiJlWBf',
            'access_token' => '8036c21a8bce50ba835ddfc1a4c410a6',
        ],

        'alternative' => [
            'client_id' => '283025b5912b7dae7c8d9a6a2c365bb02fea83d9',
            'client_secret' => 'QAL8oY6lHKLEBlhE1c8kr3YMcCRI48pCZZCtEtXONsivYacGoySm2o8EoAjkWt5cv2UxtR5WvQ9GNhckKLkOGfGVksRnSbTECzL+5sqIks3CpL8UckIw7uktSkiJlWBf',
            'access_token' => '8036c21a8bce50ba835ddfc1a4c410a6',
        ],

    ],

];
