<?php

namespace App\Http\Responses;

use App\Http\Requests\Headers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResponse implements Responsable
{
    /** @var int HTTP status code */
    private $status = HTTP_CODE_200_OK;

    /** @var array response */
    private $response;

    /**
     * @param int $status
     *
     * @return $this
     */
    public function withStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function withMessage($message)
    {
        $this->response['message'] = $message;

        return $this;
    }

    /**
     * Set the data response from a simple value, a Resource or a ResourceCollection.
     *
     * @param mixed $data
     *
     * @return $this
     */
    public function withData($data = null)
    {
        if ($this->isResourceOrCollection($data)) {
            $this->setDataAndPaginationFromResource($data);
        } else {
            $this->response['data'] = $data;
        }

        return $this;
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function withErrorCode(int $code)
    {
        $this->response['error']['code'] = $code;

        return $this;
    }

    /**
     * @param string $errorMessage
     *
     * @return $this
     */
    public function withErrorMessage(string $errorMessage)
    {
        $this->response['error']['message'] = $errorMessage;

        return $this;
    }

    /**
     * @param array $validations
     *
     * @return $this
     */
    public function withValidations($validations)
    {
        $this->response['validations'] = $validations;

        return $this;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $this->writeLog();

        return response()->json($this->response, $this->status, [JSON_UNESCAPED_UNICODE]);
    }

    /**
     * Return if the data passed to the response is an instance of Resource or ResourceCollection.
     *
     * @param $data
     *
     * @return bool
     */
    protected function isResourceOrCollection($data)
    {
        return Resource::class === get_parent_class($data) || ResourceCollection::class === get_parent_class($data);
    }

    /**
     * Set the response data and pagination values from a Resource or ResourceCollection.
     *
     * @param resource|ResourceCollection $data
     */
    protected function setDataAndPaginationFromResource($data)
    {
        $this->response['data'] = $data->response()->getData()->data ?? null;

        $links = $data->response()->getData()->links ?? null;
        $meta = $data->response()->getData()->meta ?? null;

        if ($links && $meta) {
            $total = ceil($meta->total / $meta->per_page);

            $this->response['paginator'] = [
                'prev'    => $meta->current_page > 1 ? $meta->current_page - 1 : null,
                'next'    => $meta->current_page < $total ? $meta->current_page + 1 : null,
                'current' => $meta->current_page,
                'total'   => ceil($meta->total / $meta->per_page),
                'limit'   => $meta->per_page,
                //'prevLink'    => $links->prev,
                //'nextLink'    => $links->next,
                //'lastLink'    => $links->last,
            ];
        }
    }

    /**
     * Write a daily log with failed requests.
     */
    private function writeLog()
    {
        if ($this->status < HTTP_CODE_500_INTERNAL_SERVER_ERROR || TESTING_ENVIRONMENT === env('APP_ENV')) {
            return;
        }

        $log = implode(PHP_EOL, [
            request()->getMethod().' '.request()->getPathInfo(),
            'Headers: '.json_encode(Headers::asArray()),
            'Params: '.json_encode(request()->all()),
            'Response: '.json_encode($this->response),
        ]);

        Log::emergency(PHP_EOL.PHP_EOL.$log.PHP_EOL);
    }
}
