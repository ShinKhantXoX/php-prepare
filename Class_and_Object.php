<?php
class Car {
    private string $color;
    private string $model;
    private string $brand;
    private int $year;
    private float $price;

    public function __construct(string $color, string $model, string $brand, int $year, float $price) {
        $this->color = $color;
        $this->model = $model;
        $this->brand = $brand;
        $this->year = $year;
        $this->price = $price;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function getModel(): string {
        return $this->model;
    }

    public function getBrand(): string {
        return $this->brand;
    }

    public function getYear(): int {
        return $this->year;
    }

}

$car = new Car("Red", "Model S", "Tesla", 2022, 79999.99);
echo "Car Details:\n";
echo "Color: " . $car->getColor() . "\n";
echo "Model: " . $car->getModel() . "\n";