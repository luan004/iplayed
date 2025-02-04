<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../helpers/Conn.php';
require_once __DIR__ . '/../helpers/RequestHelper.php';
require_once __DIR__ . '/../helpers/JwtHelper.php';

class UserController
{
    public static function register()
    {
        $req = RequestHelper::getBody();

        $conn = new Conn();
        $userDAO = new UserDAO($conn);

        switch (true) 
        {
            case !isset($req) || !array_key_exists('username', $req) || !array_key_exists('password', $req):
                return [
                    'http_code' => 400,
                    'body' => ['message' => 'error: username and password are required']
                ];
            case strlen($req['username']) < 3 || strlen($req['password']) < 3:
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: username and password must have at least 3 characters']
                ];
            case preg_match('/\s/', $req['username']) || preg_match('/\s/', $req['password']):
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: username and password must not have spaces']
                ];
            case $userDAO->userExistsByUsername($req['username']):
                return [
                    'http_code' => 409,
                    'body' => ['message' => 'error: user already exists']
                ];
        }

        $user = new User(0, $req['username'], sha1($req['password']));
        $userDAO->create($user);

        return [
            'http_code' => 201,
            'body' => [
                'status' => 'success',
                'message' => 'user created'
            ]
        ];

    }

    public static function login()
    {
        $req = RequestHelper::getBody();

        $conn = new Conn();
        $userDAO = new UserDAO($conn);
        $user = $userDAO->getUserByUsernameAndPassword($req['username'], sha1($req['password']));

        switch (true) {
            case !$user:
                return [
                    'http_code' => 401,
                    'body' => [
                        'status' => 'error',
                        'message' => 'incorrect username or password'
                    ]
                ];
        }

        $jwt = JwtHelper::createJwtToken(['user_id' => $user->getId(), 'username' => $user->getUsername()]);

        return [
            'http_code' => 200,
            'body' => [
                'status' => 'success',
                'message' => 'user successfully authenticated',
                'jwt' => $jwt
            ]
        ];
    }
}