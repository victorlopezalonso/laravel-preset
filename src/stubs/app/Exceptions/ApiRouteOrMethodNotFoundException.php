<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiRouteOrMethodNotFoundException extends ApiException
{

    protected $status = HTTP_CODE_404_NOT_FOUND;

    /**
     * BadRequestException constructor.
     * @internal param string $copy
     */
    public function __construct()
    {
        parent::__construct();
        $this->message      = Copy::server('ROUTE_OR_METHOD_NOT_FOUND');
    }

}
