<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiTooManyLoginAttemptsException extends ApiException
{
    protected $status = HTTP_CODE_429_TOO_MANY_REQUESTS;

    /**
     * BadRequestException constructor.
     *
     * @param string $seconds
     *
     * @internal param string $copy
     */
    public function __construct($seconds)
    {
        parent::__construct();

        $this->message = Copy::server(TOO_MANY_LOGIN_ATTEMPTS, $seconds);
    }
}
