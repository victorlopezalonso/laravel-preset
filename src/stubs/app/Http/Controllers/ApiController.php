<?php

namespace App\Http\Controllers;

use finfo;
use App\Models\Copy;
use App\Models\User;
use App\Helpers\StorageHelper;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    /** @var ApiResponse JSON basic response */
    private $response;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->response = new ApiResponse();
    }

    /**
     * @return User
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Set the ApiResponse object message.
     *
     * @param $message
     * @param bool $isCopy
     *
     * @return ApiResponse
     */
    public function withMessage($message, bool $isCopy = true)
    {
        $message = $isCopy ? Copy::server($message) : $message;

        return $this->response->withMessage($message);
    }

    /**
     * Set the status property of the ApiResponse.
     *
     * @param int $status
     *
     * @return ApiResponse
     */
    public function withStatus($status)
    {
        return $this->response->withStatus($status);
    }

    /**
     * Create a response with a 201 HTTP status.
     *
     * @param null $data
     *
     * @return ApiResponse
     */
    public function responseCreated($data = null)
    {
        return $this->response->withStatus(HTTP_CODE_201_OK_CREATED)->withData($data);
    }

    /**
     * Create a response with a 202 HTTP status.
     *
     * @param null $data
     *
     * @return ApiResponse
     */
    public function responseAccepted($data = null)
    {
        return $this->response->withStatus(HTTP_CODE_202_OK_ACCEPTED)->withData($data);
    }

    /**
     * Create a response with a 404 HTTP status.
     *
     * @param string $message
     *
     * @return ApiResponse
     */
    public function responseNotFound($message = null)
    {
        $message = $message ?: RESOURCE_NOT_FOUND;

        return $this->response->withStatus(HTTP_CODE_404_NOT_FOUND)->withMessage(Copy::server($message));
    }

    /**
     * Create a response with a 409 HTTP status.
     *
     * @param string $message
     *
     * @return ApiResponse
     */
    public function responseWithConflict($message = null)
    {
        $message = $message ?: RESOURCE_CONFLICT;

        return $this->response->withStatus(HTTP_CODE_409_CONFLICT)->withMessage(Copy::server($message));
    }

    /**
     * Devuelve un archivo como respuesta.
     *
     * @param $filename
     *
     * @return mixed
     */
    public function responseFile($filename)
    {
        $file = Storage::get(basename($filename));

        return Response::make($file, HTTP_CODE_200_OK, [
            'Content-Type'        => (new finfo(FILEINFO_MIME))->buffer($file),
            'Content-Disposition' => 'attachment; filename="'.pathinfo($filename, PATHINFO_BASENAME).'"',
        ]);
    }

    /**
     * Decrypt a file and return as binary.
     *
     * @param $filename
     *
     * @return mixed
     */
    public function responseDecryptFile($filename)
    {
        $decryptedFile = StorageHelper::getEncryptedFile($filename);

        return Response::make($decryptedFile, HTTP_CODE_200_OK, [
            'Content-Type'        => (new finfo(FILEINFO_MIME))->buffer($decryptedFile),
            'Content-Disposition' => 'attachment; filename="'.pathinfo($filename, PATHINFO_BASENAME).'"',
        ]);
    }

    /**
     * Set the data of the response object.
     *
     * @param $data
     *
     * @return ApiResponse
     */
    public function response($data = null)
    {
        return $data ? $this->response->withData($data) : $this->response;
    }
}
