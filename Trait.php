<?php


trait Timestampable {
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): string {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function setUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }

    public function getUpdatedAt(): string {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }
}

class Product {
    use Timestampable;

    private int $id;
    private string $name;
    private float $price;
    private int $stock;

    private static int $counter = 1;

    public function __construct(string $name, float $price, int $stock) {
        $this->id = self::$counter++;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    public function reduce(int $quantity): void {
        if ($quantity > $this->stock) {
            throw new Exception("Not enough stock available.");
        }
        $this->stock -= $quantity;
        $this->setUpdatedAt();
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getStock(): int {
        return $this->stock;
    }
}

class ShoppingCart {
    private array $items = [];
    
    public function addItem(Product $product, int $quantity): void {
        if (isset($this->items[$product->getName()])) {
            $this->items[$product->getName()]['quantity'] += $quantity;
        } else {
            $this->items[$product->getName()] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }
    
    public function getTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
    
    public function getItems(): array {
        return $this->items;
    }
}

// Test
$product1 = new Product("Laptop", 999.99, 10);
$product2 = new Product("Mouse", 25.50, 50);

$cart = new ShoppingCart();
$cart->addItem($product1, 2);
$cart->addItem($product2, 1);

echo "Total: \$" . number_format($cart->getTotal(), 2); // $2025.48