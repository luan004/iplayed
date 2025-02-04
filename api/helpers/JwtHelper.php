<?php

class JwtHelper
{
    private $secret = '9efe0bd7abb12f87b22c507d072834c37ace7fe45ba929de5f997e11931a68c2';

    public static function createJwtToken($payload)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $header = base64_encode($header);
        
        $payload = json_encode($payload);
        $payload = base64_encode($payload);
        
        $secret = (new self())->secret;
        $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature = base64_encode($signature);
        
        return "$header.$payload.$signature";
    }

    public static function verifyJwtToken($token)
    {
        if (empty($token)) {
            return false;
        }

        if (substr_count($token, '.') !== 2) {
            return false;
        }

        $token = explode('.', $token);
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];
        
        $secret = (new self())->secret;
        $signature2 = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature2 = base64_encode($signature2);
        
        return $signature === $signature2;
    }

    public static function getPayload($token)
    {
        $token = explode('.', $token);
        $payload = $token[1];
        $payload = base64_decode($payload);
        return json_decode($payload, true);
    }
}