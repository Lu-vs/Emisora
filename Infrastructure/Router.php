<?php
namespace Infrastructure;

class Router {
    private array $routes = [];
    private $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function add(string $method, string $pattern, callable $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => "#^" . $pattern . "$#",
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void {
        $path = strtok($uri, '?');

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) &&
                preg_match($route['pattern'], $path, $matches)) {
                array_shift($matches); // quitar full match
                echo json_encode(call_user_func_array($route['handler'], $matches));
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
    }

    public function getRepository() {
        return $this->repository;
  }

      
}

