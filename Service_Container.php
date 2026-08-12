<?php

// basic container 
class Container {
    private $bindings = [];
    private $instances = [];
    
    // Bind a class to a resolver function
    public function bind(string $abstract, $concrete): void {
        $this->bindings[$abstract] = $concrete;
    }
    
    // Bind as singleton (only one instance)
    public function singleton(string $abstract, $concrete): void {
        $this->bindings[$abstract] = $concrete;
        $this->instances[$abstract] = null; // Mark for singleton
    }
    
    // Resolve a class from the container
    public function make(string $abstract) {
        // Check if already instantiated (singleton)
        if (isset($this->instances[$abstract]) && $this->instances[$abstract] !== null) {
            return $this->instances[$abstract];
        }
        
        // Resolve the concrete
        $concrete = $this->bindings[$abstract] ?? $abstract;
        
        if ($concrete instanceof Closure) {
            $object = $concrete($this);
        } else {
            $object = $this->build($concrete);
        }
        
        // Store if singleton
        if (isset($this->instances[$abstract])) {
            $this->instances[$abstract] = $object;
        }
        
        return $object;
    }
    
    // Build a class with automatic dependency resolution
    private function build(string $class) {
        $reflector = new ReflectionClass($class);
        
        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$class} is not instantiable");
        }
        
        $constructor = $reflector->getConstructor();
        
        if (is_null($constructor)) {
            return new $class;
        }
        
        $parameters = $constructor->getParameters();
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            
            if (!$type || $type->isBuiltin()) {
                throw new Exception("Cannot resolve parameter {$parameter->getName()}");
            }
            
            $dependencies[] = $this->make($type->getName());
        }
        
        return $reflector->newInstanceArgs($dependencies);
    }
}

// Using the Basic Container
// Define interfaces and classes
// interface LoggerInterface {
//     public function log(string $message): void;
// }

// class FileLogger implements LoggerInterface {
//     public function log(string $message): void {
//         file_put_contents('/var/log/app.log', $message . PHP_EOL, FILE_APPEND);
//     }
// }

// class UserService {
//     private $logger;
//     private $db;
    
//     public function __construct(LoggerInterface $logger, Database $db) {
//         $this->logger = $logger;
//         $this->db = $db;
//     }
    
//     public function getUser($id) {
//         $this->logger->log("Fetching user: $id");
//         return $this->db->find($id);
//     }
// }

// // Configure container
// $container = new Container();

// // Bind interfaces to implementations
// $container->bind(LoggerInterface::class, FileLogger::class);

// // Bind with custom logic
// $container->singleton(Database::class, function($container) {
//     return new Database('localhost', 'user', 'pass');
// });

// // Use the container
// $userService = $container->make(UserService::class);
// $user = $userService->getUser(1);