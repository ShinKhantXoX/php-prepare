<?php

abstract class Shape {
    protected $color;
    
    public function __construct(string $color) {
        $this->color = $color;
    }
    
    // Abstract methods - must be implemented by child classes
    abstract public function calculateArea(): float;
    abstract public function calculatePerimeter(): float;
    
    // Concrete method - shared by all shapes
    public function getColor(): string {
        return $this->color;
    }
    
    public function describe(): string {
        return "A {$this->color} shape with area: " . $this->calculateArea() . 
               " and perimeter: " . $this->calculatePerimeter();
    }
}

class Circle extends Shape {
    private $radius;
    
    public function __construct(string $color, float $radius) {
        parent::__construct($color);
        $this->radius = $radius;
    }
    
    public function calculateArea(): float {
        return pi() * pow($this->radius, 2);
    }
    
    public function calculatePerimeter(): float {
        return 2 * pi() * $this->radius;
    }
}

class Rectangle extends Shape {
    private $width;
    private $height;
    
    public function __construct(string $color, float $width, float $height) {
        parent::__construct($color);
        $this->width = $width;
        $this->height = $height;
    }
    
    public function calculateArea(): float {
        return $this->width * $this->height;
    }
    
    public function calculatePerimeter(): float {
        return 2 * ($this->width + $this->height);
    }
}

class Triangle extends Shape {
    private $side1;
    private $side2;
    private $side3;
    
    public function __construct(string $color, float $side1, float $side2, float $side3) {
        parent::__construct($color);
        $this->side1 = $side1;
        $this->side2 = $side2;
        $this->side3 = $side3;
    }
    
    public function calculateArea(): float {
        // Heron's formula
        $s = ($this->side1 + $this->side2 + $this->side3) / 2;
        return sqrt($s * ($s - $this->side1) * ($s - $this->side2) * ($s - $this->side3));
    }
    
    public function calculatePerimeter(): float {
        return $this->side1 + $this->side2 + $this->side3;
    }
}

// Polymorphic function
function printShapeInfo(Shape $shape) {
    echo $shape->describe() . "\n";
    echo "Color: " . $shape->getColor() . "\n\n";
}

// Usage
$shapes = [
    new Circle("Red", 5),
    new Rectangle("Blue", 4, 6),
    new Triangle("Green", 3, 4, 5)
];

foreach ($shapes as $shape) {
    printShapeInfo($shape);
}

?>