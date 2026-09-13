<?php

declare(strict_types=1);

/**
 * Modern lightweight URL Router for ternis.org
 */
class Router
{
    /** @var array<string, array<int, array{pattern: string, regex: string, paramNames: array<string>, handler: callable}>> */
    private array $routes = [
        'GET'  => [],
        'POST' => [],
        'HEAD' => [],
    ];

    /** @var callable|null */
    private $fallbackHandler = null;

    /**
     * Register a GET route.
     */
    public function get(string $pattern, callable $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
        $this->addRoute('HEAD', $pattern, $handler);
    }

    /**
     * Register a POST route.
     */
    public function post(string $pattern, callable $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    /**
     * Register a fallback 404 handler.
     */
    public function fallback(callable $handler): void
    {
        $this->fallbackHandler = $handler;
    }

    /**
     * Internal method to compile and register route.
     */
    private function addRoute(string $method, string $pattern, callable $handler): void
    {
        preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $pattern, $matches);
        $paramNames = $matches[1] ?? [];

        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#u';

        $this->routes[$method][] = [
            'pattern'    => $pattern,
            'regex'      => $regex,
            'paramNames' => $paramNames,
            'handler'    => $handler,
        ];
    }

    /**
     * Dispatch the current request.
     */
    public function dispatch(?string $uri = null, ?string $method = null): void
    {
        $rawMethod = strtoupper($method ?? $_SERVER['REQUEST_METHOD'] ?? 'GET');
        $isHead    = ($rawMethod === 'HEAD');
        $method    = $isHead ? 'GET' : $rawMethod;
        $rawUri    = $uri ?? $_SERVER['REQUEST_URI'] ?? '/';
        $path      = parse_url($rawUri, PHP_URL_PATH) ?? '/';

        // 301 Permanent Redirect for trailing slashes (SEO best-practice)
        if ($path !== '/' && str_ends_with($path, '/')) {
            $cleanPath = rtrim($path, '/');
            $query = parse_url($rawUri, PHP_URL_QUERY);
            $target = $cleanPath . ($query !== null && $query !== '' ? '?' . $query : '');
            header('Location: ' . $target, true, 301);
            exit;
        }

        $routesForMethod = $this->routes[$method] ?? [];

        foreach ($routesForMethod as $route) {
            if (preg_match($route['regex'], $path, $matches)) {
                $params = [];
                foreach ($route['paramNames'] as $name) {
                    if (isset($matches[$name])) {
                        $params[$name] = urldecode($matches[$name]);
                    }
                }

                if ($isHead) {
                    ob_start();
                    call_user_func($route['handler'], $params);
                    ob_end_clean();
                } else {
                    call_user_func($route['handler'], $params);
                }
                return;
            }
        }

        if ($this->fallbackHandler !== null) {
            if ($isHead) {
                ob_start();
                call_user_func($this->fallbackHandler);
                ob_end_clean();
            } else {
                call_user_func($this->fallbackHandler);
            }
            return;
        }

        http_response_code(404);
        if (!$isHead) {
            echo '404 Not Found';
        }
    }
}
