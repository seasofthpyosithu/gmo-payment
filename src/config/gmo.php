<?php

return [
    'shop_id' => '',
    'shop_pass' => '',
    'site_id' => '',
    'site_pass' => '',

    'remittance_shop_id' => '',
    'remittance_shop_pass' => '',

    /*
   |--------------------------------------------------------------------------
   | Remittance Api Host
   |--------------------------------------------------------------------------
   |
   | This option determines how which api url is going to use for Remittance|Bank
   | Example
   | test api url : https://test-remittance.gmopg.jp
   | production api url : https://remittance.gmopg.jp
   | Supported: "lax", "strict"
   |
   */

    'remittance_host' => 'https://test-remittance.gmopg.jp',

    /*
    |--------------------------------------------------------------------------
    | Shop or Site Api Host
    |--------------------------------------------------------------------------
    |
    | This option determines how which api url is going to use for shop and site api
    | Example
    | test api url : https://pt01.mul-pay.jp
    | production api url : https://p01.mul-pay.jp
    | Supported: "lax", "strict"
    |
    */
    'host' => 'https://pt01.mul-pay.jp'
];
