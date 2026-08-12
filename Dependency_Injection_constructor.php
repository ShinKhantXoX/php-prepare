<?php

// Constructor Injection (Most Common)

interface DatabaseInterface {
    public function query(string $sql): array;
}

class MySQLDatabase implements DatabaseInterface {
    public function query(string $sql): array {
        // MySQL implementation
        return [];
    }
}

class PostgreSQLDatabase implements DatabaseInterface {
    public function query(string $sql): array {
        // PostgreSQL implementation
        return [];
    }
}

class UserService {
    private $db;
    
    // Dependencies are injected through constructor
    public function __construct(DatabaseInterface $db) {
        $this->db = $db;
    }
    
    public function getUser($id) {
        return $this->db->query("SELECT * FROM users WHERE id = $id");
    }
}

// Usage
$db = new MySQLDatabase();
$userService = new UserService($db);