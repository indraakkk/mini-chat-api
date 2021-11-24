<?php

namespace App\Traits;

trait JsonResponse {

    public function responseWithCondition($data, $msg, $code)
    {
        return $data ? $this->success($msg, $data)
            : $this->fail($msg, $code);
    }

    public function success($msg, $data = null, $code = 200, $version = '1.0')
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data,
            'code' => $code,
            'version' => $version
        ], $code)->header('Content-Type', 'application/json');
    }

    public function fail($msg, $code, $version = '1.0')
    {
        $data = [
            'success' => false,
            'data'    => null,
            'message' => $msg,
            'code'    => $code,
            'version' => $version
        ];

        return response()->json($data, $code)->header('Content-Type', 'application/json');
    }
}
