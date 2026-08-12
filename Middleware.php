<?php

// Basic Middleware Interface
interface Middleware {
    public function process(Request $request, RequestHandler $handler): Response;
}

interface RequestHandler {
    public function handle(Request $request): Response;
}

// Example Middleware Implementation
class Request {
    private array $data = [];
    private array $headers = [];
    private string $uri;
    private string $method;
    
    public function __construct(string $method, string $uri, array $data = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->data = $data;
    }
    
    public function getUri(): string { return $this->uri; }
    public function getMethod(): string { return $this->method; }
    public function getData(): array { return $this->data; }
    public function getHeader(string $name): ?string { 
        return $this->headers[$name] ?? null; 
    }
}

class Response {
    private int $statusCode;
    private array $headers = [];
    private string $body;
    
    public function __construct(string $body, int $statusCode = 200) {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }
    
    public function send(): void {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->body;
    }
}

class CoreHandler implements RequestHandler {
    public function handle(Request $request): Response {
        // Application core logic
        return new Response("Hello " . ($request->getData()['name'] ?? 'World'));
    }
}

// ----------------- Middleware Example -----------------
// 1. Authentication Middleware

class AuthMiddleware implements Middleware {
    private array $validTokens = ['abc123', 'def456'];
    
    public function process(Request $request, RequestHandler $handler): Response {
        $token = $request->getHeader('Authorization');
        
        if (!$token || !in_array($token, $this->validTokens)) {
            return new Response('Unauthorized', 401);
        }
        
        // Add user data to request
        $request->data['user_id'] = 123;
        
        return $handler->handle($request);
    }
}

// 2. Logging Middleware
class LoggingMiddleware implements Middleware {
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }
    
    public function process(Request $request, RequestHandler $handler): Response {
        $start = microtime(true);
        $this->logger->info("Request: {$request->getMethod()} {$request->getUri()}");
        
        $response = $handler->handle($request);
        
        $duration = microtime(true) - $start;
        $this->logger->info("Response: {$response->getStatusCode()} ({$duration}ms)");
        
        return $response;
    }
}

// 3. CORS Middleware
class CorsMiddleware implements Middleware {
    private array $allowedOrigins = ['https://example.com', 'https://api.example.com'];
    
    public function process(Request $request, RequestHandler $handler): Response {
        $origin = $request->getHeader('Origin');
        
        if (!in_array($origin, $this->allowedOrigins)) {
            return new Response('CORS origin not allowed', 403);
        }
        
        $response = $handler->handle($request);
        $response->setHeader('Access-Control-Allow-Origin', $origin);
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        
        return $response;
    }
}

// 4. Rate Limiting Middleware
class RateLimitMiddleware implements Middleware {
    private array $requests = [];
    private int $limit;
    private int $timeWindow;
    
    public function __construct(int $limit = 100, int $timeWindow = 3600) {
        $this->limit = $limit;
        $this->timeWindow = $timeWindow;
    }
    
    public function process(Request $request, RequestHandler $handler): Response {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = "rate_limit:$ip";
        $currentTime = time();
        
        // Clean old requests
        $this->requests[$key] = array_filter(
            $this->requests[$key] ?? [],
            fn($time) => $time > ($currentTime - $this->timeWindow)
        );
        
        if (count($this->requests[$key] ?? []) >= $this->limit) {
            return new Response('Rate limit exceeded', 429);
        }
        
        $this->requests[$key][] = $currentTime;
        
        return $handler->handle($request);
    }
}

// 5. JSON Parsing Middleware
class JsonBodyMiddleware implements Middleware {
    public function process(Request $request, RequestHandler $handler): Response {
        if ($request->getHeader('Content-Type') === 'application/json') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                return new Response('Invalid JSON', 400);
            }
            
            $request->data = array_merge($request->getData(), $data);
        }
        
        return $handler->handle($request);
    }
}