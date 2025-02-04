<?php

require_once __DIR__ . '/../dao/SearchDAO.php';
require_once __DIR__ . '/../helpers/Conn.php';
require_once __DIR__ . '/../helpers/RequestHelper.php';

class searchController
{
    public static function instant($query)
    {
        switch (true)
        {
            case !isset($query) || strlen($query) < 3:
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: query must have at least 3 characters']
                ];
        }

        $conn = new Conn();
        $searchDAO = new SearchDAO($conn);

        $games = $searchDAO->searchGamesByName($query, 10, 1);
        $platforms = $searchDAO->searchPlatformsByName($query, 5);
        $developers = $searchDAO->searchDevelopersByName($query, 5);

        $conn->close();

        return [
            'http_code' => 200,
            'body' => [
                'games' => $games,
                'platforms' => $platforms,
                'developers' => $developers
            ]
        ];
    }

    public static function games($query)
    {
        $req = RequestHelper::getBody();

        switch (true)
        {
            case !isset($query) || strlen($query) < 3:
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: query must have at least 3 characters']
                ];
            case !isset($req) || !array_key_exists('page', $req) || !is_numeric($req['page']) || !array_key_exists('limit', $req) || !is_numeric($req['limit']):
                return [
                    'http_code' => 400,
                    'body' => ['message' => 'error: page and limit are required and must be numeric']
                ];
            case $req['page'] < 1 || $req['limit'] < 1:
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: page and limit must be greater than 0']
                ];
            case $req['limit'] > 100:
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: limit must be less than 100']
                ];
            case !is_int($req['page']) || !is_int($req['limit']):
                return [
                    'http_code' => 422,
                    'body' => ['message' => 'error: page and limit must be integers']
                ];
        }

        $conn = new Conn();
        $searchDAO = new SearchDAO($conn);

        $games = $searchDAO->searchGamesByName($query, $req['limit'], $req['page']);

        $conn->close();

        return [
            'http_code' => 200,
            'body' => [
                'page' => $req['page'],
                'limit' => $req['limit'],
                'games' => $games
            ]
        ];
    }
}