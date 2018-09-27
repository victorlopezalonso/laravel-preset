<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiForbiddenException extends ApiException
{

    protected $status = HTTP_CODE_403_FORBIDDEN;

    /**
     * UnauthorizedException constructor.
     * @param int $code
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
