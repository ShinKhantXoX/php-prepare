<?php

// Pipeline Implementation

class MiddlewarePipeline implements RequestHandler {
    private array $middleware = [];
    private RequestHandler $finalHandler;
    
    public function __construct(RequestHandler $finalHandler) {
        $this->finalHandler = $finalHandler;
    }
    
    public function add(Middleware $middleware): self {
        $this->middleware[] = $middleware;
        return $this;
    }
    
    public function handle(Request $request): Response {
        $handler = $this->buildChain();
        return $handler->handle($request);
    }
    
    private function buildChain(): RequestHandler {
        $handler = $this->finalHandler;
        
        // Process middleware in reverse
        foreach (array_reverse($this->middleware) as $middleware) {
            $next = $handler;
            $handler = new class($middleware, $next) implements RequestHandler {
                private $middleware;
                private $next;
                
                public function __construct($middleware, $next) {
                    $this->middleware = $middleware;
                    $this->next = $next;
                }
                
                public function handle(Request $request): Response {
                    return $this->middleware->process($request, $this->next);
                }
            };
        }
        
        return $handler;
    }
}

// Using the Pipeline

// Setup
$pipeline = new MiddlewarePipeline(new CoreHandler());

$pipeline
    ->add(new CorsMiddleware())
    ->add(new JsonBodyMiddleware())
    ->add(new RateLimitMiddleware(10, 60))
    ->add(new LoggingMiddleware(new FileLogger()))
    ->add(new AuthMiddleware());

// Process request
$request = new Request('POST', '/api/users', ['name' => 'John']);
$response = $pipeline->handle($request);
$response->send();