<?php

//require_once __DIR__ . '\controllers\UserController.php';
require_once __DIR__ . '\controllers\SearchController.class.php';

$routes = [
    'GET'   => [
        '/' => function($data) {
            return [
                'http_code' => 200,
                'body' => [
                    'status' => 'success',
                    'message' => 'welcome! :D'
                ]
            ];
        },
        '/search/instant/{query}' => fn($data) => SearchController::instant($data),
        '/search/games/{query}/{page}/{limit}'   => fn($data) => SearchController::games($data),
        '/teste/{id}/{username}'  => fn($data) => teste($data),
        '/teste/{id}'             => fn($data) => teste($data),
        '/teste'                  => fn($data) => teste($data),
    ],
    'POST'  => [
        '/login'    => fn($data) => UserController::login($data),
        '/register' => fn($data) => UserController::register($data)
    ]
];


function teste($request) {
    return [
        'http_code' => 200,
        'body' => [
            'deu' => 'certo',
            'request' => $request
        ]
    ];
}
 
function handleRoute($routes)
{
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uri = str_replace('api', '', $uri);
    

    $found = false;

    $headers = getallheaders();
    $payload = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    foreach ($routes[$method] as $route => $callback) {
        // Extrair os nomes dos placeholders {param}
        preg_match_all('/\{([^\}]+)\}/', $route, $paramNames);
        $paramNames = $paramNames[1]; // Pegamos apenas os nomes dos parâmetros

        // Criar um padrão regex para capturar valores dinâmicos
        $pattern = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $route);
        $pattern = "#^" . $pattern . "$#";

        // Verificar se a URI combina com a rota atual
        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove o primeiro elemento do array (a string inteira encontrada)

            // Associar os nomes dos parâmetros aos valores capturados
            $params = (!empty($paramNames)) ? array_combine($paramNames, array_map('urldecode', $matches)) : [];

            // Converter valores para seus tipos corretos
            foreach ($params as $key => $value) {
                if (is_numeric($value)) {
                    // Se for inteiro, converte para int; se for decimal, para float
                    $params[$key] = (strpos($value, '.') !== false) ? (float) $value : (int) $value;
                } elseif (strtolower($value) === 'true' || strtolower($value) === 'false') {
                    // Converter para booleano
                    $params[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }
            
            // Criar array com headers, parâmetros e payload
            $data = [
                'headers' => $headers,
                'params' => $params,
                'payload' => $payload
            ];

            $response = call_user_func($callback, $data);

            http_response_code($response['http_code'] ?? 400);
            echo json_encode($response['body'] ?? []);
            $found = true;
            break;
        }
    }

    if (!$found) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'route not found', 'uri' => $uri]);
    }
}

