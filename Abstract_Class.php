<?php

abstract class Animal {
    protected string $name;
    protected int $age;

    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }

    // Abstract method - must be implemented by child classes
    abstract public function makeSound(): string;

    public function eat(): string {
        return $this->name . " is eating.";
    }
}


class Dog extends Animal {
    private string $breed;

    public function __construct(string $name, int $age, string $breed) {
        parent::__construct($name, $age);
        $this->breed = $breed;
    }

    public function makeSound(): string {
        return "Woof! Woof!";
    }
}

class Cat extends Animal {
    public function makeSound(): string {
        return "Meow! Meow!";
    }
}

$dog = new Dog("Buddy", 3, "Golden Retriever");
echo $dog->makeSound() . "\n"; // Output: Woof! Woof
echo $dog->eat() . "\n"; // Output: Buddy is eating.


