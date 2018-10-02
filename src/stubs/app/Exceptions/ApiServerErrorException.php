<?php

namespace App\Exceptions;

class ApiServerErrorException extends ApiException
{
    protected $status = HTTP_CODE_500_INTERNAL_SERVER_ERROR;

    /**
     * ValidationException constructor.
     *
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        parent::__construct();

        $this->code = \is_int($exception->getCode()) ? $exception->getCode() : 0;

        $this->errorMessage = "{$exception->getMessage()} in ".basename($exception->getFile())." ({$exception->getLine()})";
    }
}
