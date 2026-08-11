<?php

class BankAccount {
    private float $balance = 0;
    private string $accountNumber;
    private static int $accountCounter = 100;

    public function __construct(float $initialBalance) {
        $this->balance = $initialBalance;
        $this->accountNumber = "ACC" . self::$accountCounter++; // Increment account counter for unique account numbers
    }

    public function deposit(float $amount) : void {
        if ($amount > 0) {
            $this->balance += $amount;
        } else {
            echo "Deposit amount must be positive.\n";
        }
    }

    public function withdraw(float $amount): void {
        if($amount < 0 || $amount > $this->balance) {
            echo "Invalid withdrawal amount.\n";
        } else {
            $this->balance -= $amount;
        }
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function getAccountNumber(): string {
        return $this->accountNumber;
    }
}

// Usage example
$account = new BankAccount(10000);
$account->deposit(5000);
echo "Account Number: " . $account->getAccountNumber() . "\n";
echo "Balance after deposit: $" . $account->getBalance() . "\n";
$account->withdraw(3000);
echo "Balance after withdrawal: $" . $account->getBalance() . "\n";