<?php

namespace App\Http\Responses;

use App\Enums\ErrorCode;
use Log;

class Response
{
    /**
     * list
     */
    protected $datas = [
        'items'    => null, // array
        'total'    => null,
        'nextPage' => null,
        'prePage'  => null,
    ];

    /**
     * single
     */
    public $data;
    public $message;
    public $errorMessage; // array

    public function responseData()
    {
        $dataResponse = [
            'message' => $this->message,
            'data'    => $this->data,
        ];

        return response()->json($dataResponse, ErrorCode::OK);
    }

    public function responseMultiData()
    {
        $dataResponse = [
            'message' => $this->message,
            'data'    => $this->datas,
        ];

        return response()->json($dataResponse, ErrorCode::OK);
    }
    
    public function badRequest()
    {
        $dataResponse = [
            'message' => $this->message,
            'data'    => $this->errorMessage,
        ];

        Log::error(json_encode($this->errorMessage, JSON_UNESCAPED_UNICODE));

        return response()->json($dataResponse, ErrorCode::BAD_REQUEST);
    }

    public function formatInvalid()
    {
        $dataResponse = [
            'message' => "Data request invalid",
        ];
        return response()->json($dataResponse, ErrorCode::BAD_REQUEST);
    }

    public function unauthorized()
    {
        $dataResponse = [
            'message' => $this->message,
        ];
        return response()->json($dataResponse, ErrorCode::UNAUTHORIZED);
    }

    public function permission()
    {
        $dataResponse = [
            'message' => $this->message,
        ];
        return response()->json($dataResponse, ErrorCode::FORBIDDEN);
    }

}
