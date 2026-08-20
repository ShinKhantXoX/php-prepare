<?php

class User {
    public $age;
    private $password;
    protected $name;

    public function __construct(int $age, string $password, string $name)
    {
        $this->age = $age;
        $this->password = $password;
        $this->name = $name;
    }

    public function getUserName () 
    {
        return $this->name;
    }

    public function getUserAge ()
    {
        return $this->age;
    }
}

class NewUser extends User {
    public $email;
    public $phone;

    public function __construct(int $age, string $password, string $name, string $email, string $phone)
    {
        parent::__construct($age, $password, $name);

        $this->email = $email;
        $this->phone = $phone;
    }

    public function getUserInfo() 
    {
        $userInfo = $this->email . " " . $this->phone . ' ' . $this->name;
        return $userInfo;
    }
}

$newUser = new NewUser(25, 'secure123', 'Shin', 'shin@email.com', '123-456-7890');

// Test protected property access
echo "=== Testing Protected Property ===\n";
echo "Full info: " . $newUser->getUserInfo() . "\n";  // Can access protected $name via method
echo "Name via parent method: " . $newUser->getUserName() . "\n";  // Works too
// echo "Get User name from the outside ". $newUser->name; // Cannot access protected property