<?php
namespace ITATS\PraktikumTeknikSipil\App;

use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Services\ErrorController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Services\DebugController;
use Exception;

class Router {
    private static array $routes = [];
    private static bool $routeFound = false;

    public static function add(string $method, string $path, string $controller, string $function, array $middlewares = []) {
        $patternPath = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path);
        $compiledPattern = "#^" . $patternPath . "$#i";

        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $compiledPattern,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middlewares
        ];
    }

    public static function run() {
        ob_start(); // Start output buffer
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        Config::loadEnv();

        // Error handler for warnings
        set_error_handler(function ($severity, $message, $file, $line) {
            if (!(error_reporting() & $severity)) return;

            if (in_array($severity, [E_WARNING, E_USER_WARNING, E_NOTICE, E_USER_NOTICE])) {
                if (Config::get('APP_ENV') !== 'production') {
                    DebugController::showWarning([
                        'message' => $message,
                        'file' => $file,
                        'line' => $line
                    ]);
                }
            }

            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        // Global exception handler
        set_exception_handler(function ($e) {
            if (Config::get('APP_ENV') === 'production') {
                (new ErrorController())->error500();
            } else {
                DebugController::showException($e);
            }
        });

        // Shutdown function for fatal errors
        register_shutdown_function(function () {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_CORE_ERROR])) {
                if (Config::get('APP_ENV') === 'production') {
                    (new ErrorController())->error500();
                } else {
                    DebugController::showFatal($error);
                }
            }
            ob_end_flush();
        });

        // CORS OPTIONS handler
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            exit;
        }

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Asset handler: /assets/...
        if (preg_match('#^/assets/(.*)$#', $path, $matches)) {
            $filePath = $matches[1];
            $fullPath = dirname(__DIR__, 2) . "/resources/$filePath";

            if (file_exists($fullPath)) {
                $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                $mime = match ($ext) {
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'jpg', 'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'svg' => 'image/svg+xml',
                    'webp' => 'image/webp',
                    'woff' => 'font/woff',
                    'woff2' => 'font/woff2',
                    'ttf' => 'font/ttf',
                    'otf' => 'font/otf',
                    'eot' => 'application/vnd.ms-fontobject',
                    'ico' => 'image/x-icon',
                    'json', 'map' => 'application/json',
                    default => mime_content_type($fullPath) ?: 'application/octet-stream'
                };

                header("Content-Type: $mime");
                readfile($fullPath);
                exit;
            } else {
                http_response_code(404);
                echo "Asset not found: $filePath";
                exit;
            }
        }

        // Maintenance & Payment Mode
        $appEnv = Config::get('APP_ENV');
        $errorController = new ErrorController();

        if ($appEnv === 'maintenance') {
            $errorController->maintenance();
            exit;
        } elseif ($appEnv === 'payment') {
            $errorController->payment();
            exit;
        }

        // Error Reporting Mode
        if ($appEnv === 'production') {
            error_reporting(0);
            ini_set('display_errors', '0');
            ini_set('log_errors', '1');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        try {
            foreach (self::$routes as $route) {
                if ($method !== $route['method']) continue;

                if (preg_match($route['path'], $path, $matches)) {
                    foreach ($route['middleware'] as $middleware) {
                        $middlewareInstance = is_array($middleware)
                            ? new $middleware[0](...array_slice($middleware, 1))
                            : new $middleware();
                        $middlewareInstance->before();
                    }

                    if (!class_exists($route['controller'])) {
                        throw new Exception("Controller {$route['controller']} tidak ditemukan");
                    }

                    $controller = new $route['controller']();
                    $function = $route['function'];

                    if (!method_exists($controller, $function)) {
                        throw new Exception("Method {$function} tidak ditemukan di {$route['controller']}");
                    }

                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    call_user_func_array([$controller, $function], $params);
                    self::$routeFound = true;
                    return;
                }
            }

            if (!self::$routeFound) {
                self::handle404();
            }
        } catch (Exception $e) {
            self::handle500($e);
        }
    }

    public static function handleAbort(string $message = "Akses ditolak") {
        http_response_code(403);
        if (Config::get('APP_ENV') === 'production') {
            (new ErrorController())->error403();
        } else {
            echo "<strong>403 Forbidden</strong><br>";
            echo "<strong>Alasan:</strong> $message<br>";
        }
        exit;
    }

    private static function handle500(Exception $e) {
        if (ob_get_length()) ob_end_clean();
        http_response_code(500);

        if (Config::get('APP_ENV') === 'production') {
            $controller = new ErrorController();
            $controller->error500();
        } else {
            DebugController::showException($e);
        }

        exit;
    }

    private static function handle404() {
        if (ob_get_length()) ob_end_clean();
        http_response_code(404);
        $controller = new ErrorController();
        $controller->error404();
        exit;
    }

    public static function cacheRoutes() {
        if (Config::get('APP_ENV') === 'production') {
            $cacheDir = __DIR__ . '/../Storage/cache';
            $cacheFile = $cacheDir . '/routes.cache';

            if (!file_exists($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }

            if (!file_exists($cacheFile)) {
                file_put_contents($cacheFile, '<?php return ' . var_export(self::$routes, true) . ';');
            }
        }
    }
}
