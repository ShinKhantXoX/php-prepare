<?php

class Vehicle {
    protected string $brand;
    protected string $model;
    protected int $year;

    public function __construct(string $brand, string $model, int $year) {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function start(): string {
        return "Vehicle is starting...";
    }

}

class ElectricCar extends Vehicle {
    private int $batteryCapacity;
    private float $price;

    public function __construct(string $brand, string $model, int $year, int $batteryCapacity, float $price) {
        parent::__construct($brand, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
        $this->price = $price;
    }

    // Method overriding
    public function start(): string {
        return "Electric motor silently starting...";
    }
    
    public function charge(): string {
        return "Charging battery...";
    }
}

$electricCar = new ElectricCar("Tesla", "Model S", 2022, 100, 79999.99);
echo "Electric Car Details:\n";
echo "Electric Car Start:". $electricCar->start() . "\n";
echo "Electric Car Charge:". $electricCar->charge() . "\n";