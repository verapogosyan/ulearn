<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = 'Resource';
    }

    public static function getApiHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'X-Api-Version' => config('app.version')
        ];
    }

    protected function response($data, $statusCode)
    {
        if (isset($data['message'])) {
            $message = $data['message'];
            switch ($message) {
                case 'created':
                    $data['message'] = trans('texts.resource_created', ['name' => $this->model]);
                    break;
                case 'updated':
                    $data['message'] = trans('texts.resource_updated', ['name' => $this->model]);
                    break;
                case 'deleted':
                    $data['message'] = trans('texts.resource_deleted', ['name' => $this->model]);
                    break;
            }
        }

        $response = json_encode($data, JSON_PRETTY_PRINT);


        return response()->make($response, $statusCode, self::getApiHeaders());
    }

    protected function notFoundResponse($resource = null)
    {
        return response()->make(trans('texts.not_found', ['name' => $resource ?? $this->model]), 404, self::getApiHeaders());
    }

    protected function somethingWentWrongResponse()
    {
        return response()->make(trans('texts.something_went_wrong'), 500, self::getApiHeaders());
    }
}
