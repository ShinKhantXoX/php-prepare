<?php

// Setter Injection

// class UserService {
//     private $logger;
//     private $cache;
    
//     public function setLogger(LoggerInterface $logger): void {
//         $this->logger = $logger;
//     }
    
//     public function setCache(CacheInterface $cache): void {
//         $this->cache = $cache;
//     }
    
//     public function getUser($id) {
//         if ($this->cache && $this->cache->has("user:$id")) {
//             return $this->cache->get("user:$id");
//         }
        
//         // Fetch user logic...
        
//         if ($this->logger) {
//             $this->logger->info("User $id fetched");
//         }
//     }
// }

// // Usage
// $userService = new UserService();
// $userService->setLogger(new FileLogger());
// $userService->setCache(new RedisCache());