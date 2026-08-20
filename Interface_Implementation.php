<?php

interface PaymentMethod {
    public function processPayment(float $amount): bool;
    public function getPaymentType(): string;
}

class CreditCard implements PaymentMethod {
    private $cardNumber;
    private $expiryDate;
    
    public function __construct(string $cardNumber, string $expiryDate) {
        $this->cardNumber = $cardNumber;
        $this->expiryDate = $expiryDate;
    }
    
    public function processPayment(float $amount): bool {
        echo "Processing \${$amount} via Credit Card ending in " . substr($this->cardNumber, -4) . "\n";
        return true;
    }
    
    public function getPaymentType(): string {
        return "Credit Card";
    }
}

class PayPal implements PaymentMethod {
    private $email;
    
    public function __construct(string $email) {
        $this->email = $email;
    }
    
    public function processPayment(float $amount): bool {
        echo "Processing \${$amount} via PayPal account: {$this->email}\n";
        return true;
    }
    
    public function getPaymentType(): string {
        return "PayPal";
    }
}

class BankTransfer implements PaymentMethod {
    private $accountNumber;
    
    public function __construct(string $accountNumber) {
        $this->accountNumber = $accountNumber;
    }
    
    public function processPayment(float $amount): bool {
        echo "Processing \${$amount} via Bank Transfer from account: {$this->accountNumber}\n";
        return true;
    }
    
    public function getPaymentType(): string {
        return "Bank Transfer";
    }
}

// Polymorphic function
function processTransaction(PaymentMethod $payment, float $amount) {
    echo "Payment Type: " . $payment->getPaymentType() . "\n";
    $result = $payment->processPayment($amount);
    echo $result ? "Transaction successful!\n" : "Transaction failed!\n";
    echo "---\n";
}

// Usage
$creditCard = new CreditCard("1234567812345678", "12/25");
$paypal = new PayPal("user@example.com");
$bankTransfer = new BankTransfer("9876543210");

processTransaction($creditCard, 150.50);
processTransaction($paypal, 75.25);
processTransaction($bankTransfer, 500.00);

?>