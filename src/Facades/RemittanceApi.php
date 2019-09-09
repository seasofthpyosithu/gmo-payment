<?php

namespace Seasofthpyosithu\GmoPayment\Facades;

use Illuminate\Support\Facades\Facade;

class RemittanceApi extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'remittance-api';
    }
}
