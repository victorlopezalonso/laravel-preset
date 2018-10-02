<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiUnauthorizedException extends ApiException
{
    protected $status = HTTP_CODE_401_UNAUTHORIZED;

    /**
     * UnauthorizedException constructor.
     *
     * @param int $code
     *
     * @internal param bool $isRefreshTokenExpired
     */
    public function __construct(int $code = 0)
    {
        parent::__construct();

        $message = Copy::server(UNAUTHORIZED_REQUEST);

        $this->message = $message;

        $this->code = $code;

        $this->errorMessage = $message;
    }
}
