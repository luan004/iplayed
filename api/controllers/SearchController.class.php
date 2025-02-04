<?php

require_once __DIR__ . '/../controllers/Controller.class.php';
require_once __DIR__ . '/../dao/SearchDao.class.php';

class searchController extends Controller
{
    public static function instant($request)
    {
        $params = $request['params'];

        $query = $params['query'];

        $validation = self::validate([
            [
                'validation' => strlen($query) < 3,
                'http_code' => 400,
                'error_type' => 1,
                'message' => 'A query deve ter ao menos 3 caracteres'
            ]
        ]);

        if ($validation) return $validation;

        $conn = new Conn();
        $searchDAO = new SearchDao($conn);

        $games = $searchDAO->searchGamesByName($query, 10, 1);
        $platforms = $searchDAO->searchPlatformsByName($query, 5);
        $developers = $searchDAO->searchDevelopersByName($query, 5);

        $conn->close();

        return self::response(200, [
            'games' => $games,
            'platforms' => $platforms,
            'developers' => $developers
        ]);
    }

    public static function games($data)
    {
        $params = $data['params'];

        $query = $params['query'];
        $page = $params['page'];
        $limit = $params['limit'];

        $validation = self::validate([
            [
                'validation' => !is_int($page) || $page < 1,
                'http_code' => 400,
                'error_type' => 1,
                'message' => 'page value must be integer and greater than 0'
            ],
            [
                'validation' => !is_int($limit) || $limit < 1 || $limit > 100,
                'http_code' => 400,
                'error_type' => 2,
                'message' => 'limit value must be an integer greater than 0 and equal or less than 100'
            ],
            [
                'validation' => strlen($query) < 3,
                'http_code' => 400,
                'error_type' => 3,
                'message' => 'the search query lenght must be grater than 2 characters'
            ]
        ]);

        if ($validation) return $validation;

        $conn = new Conn();
        $searchDAO = new SearchDao($conn);

        $games = $searchDAO->searchGamesByName($query, $limit, $page);

        $conn->close();

        return [
            'http_code' => 200,
            'body' => [
                'page' => $page,
                'limit' => $limit,
                'games' => $games
            ]
        ];
    }
}