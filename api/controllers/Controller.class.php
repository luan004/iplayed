<?php

class Controller
{
    protected static function validate($conditions)
    {
        foreach ($conditions as $condition) {
            if ($condition['validation']) {
                return self::response(
                    $condition['http_code'],
                    [
                        'status' => 'failure',
                        'error_type' => $condition['error_type'],
                        'message' => $condition['message']
                    ]
                );
            }
        }
        return null;
    }

    protected static function response($http_code, $body = [])
    {
        return [
            'http_code' => $http_code,
            'body' => $body
        ];
    }
}