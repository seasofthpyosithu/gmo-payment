<?php

namespace Seasofthpyosithu\GmoPayment\GmoPaymentApi;


use Exception;
use Throwable;

class GmoPaymentException extends Exception
{
    use ErrorTrait;
    private $errors = [];

    public function __construct($message = "", $code = 0, Throwable $previous = null, string $errors = '')
    {
        parent::__construct($message, $code, $previous);

        if ($errors !== '') {
            $this->errors = explode("|", $errors);
        }
    }

    public function getErrors() {
        $list = [];

        foreach ($this->errors as $error) {
            if(isset($this->jpErrors[$error])) {
                $list[$error] = $this->jpErrors[$error];
            } else {
                $list[$error] = 'This error does not contain in our library for detail check https://faq.gmo-pg.com/service/detail.aspx?id=480&a=102&isCrawler=1';
            }
        }
        return $list;
    }
}
