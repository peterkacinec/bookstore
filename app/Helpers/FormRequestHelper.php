<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class FormRequestHelper
{
    public static function failedValidation($errors)
    {
        if (request()->ajax()) {
            $response = [
                "success" => false,
                "message" => __("general.The given data was invalid"),
                "errors" => $errors,
            ];

            throw new HttpResponseException(response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
