<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseMessage
{
    /**
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function success($data = [], $status = 200)
    {
        $data['message'] = 'Success';

        return response()->json($data, $status);
    }

    /**
     * @param $exception
     * @return JsonResponse
     */
    protected function error($exception)
    {
        return response()->json($exception->getMessage(), $exception->getCode());
    }
}
