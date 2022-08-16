<?php

namespace App\Libraries;

use App\Constants\ResponseConstants;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as Response;

/**
 * Class ResponseLibrary
 * @package App\Libraries
 */
class ResponseLibrary extends ResponseConstants
{
    /**
     * Returns success format
     * @param string $sMessage
     * @return JsonResponse
     */
    public static function successResponse(string $sMessage, int $iStatusCode = self::OK_REQUEST): JsonResponse
    {
        return Response::json([
            self::RESULT => self::SUCCESS,
            self::MESSAGE   => $sMessage,
        ], $iStatusCode);
    }


    /**
     * Returns success format with data
     * @param array $aData
     * @return JsonResponse
     */
    public static function successDataResponse(array $aData, int $iStatusCode = self::OK_REQUEST): JsonResponse
    {
        return Response::json([
            self::RESULT => self::SUCCESS,
            self::DATA   => $aData,
        ], $iStatusCode);
    }

    /**
     * Returns error response
     * @param $mMessage
     * @param int $iHttpCode
     * @return JsonResponse
     */
    public static function errorResponse($mMessage, int $iHttpCode): JsonResponse
    {
        return Response::json([
            self::RESULT  => self::FAIL,
            self::MESSAGE => $mMessage,
        ], $iHttpCode);
    }

    /**
     * Return Data not found response
     * @return JsonResponse
     */
    public static function noDataResponse($mMessage = self::NO_DATA): JsonResponse
    {
        return self::errorResponse($mMessage, self::NOT_FOUND);
    }
}
