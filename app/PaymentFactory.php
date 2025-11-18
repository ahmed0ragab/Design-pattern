<?php

// Complete implementation in a single file
interface Payment {
    public function processPayment(float $amount): void;
    public function getPaymentType(): string;
}

class PayPalPayment implements Payment {
    public function processPayment(float $amount): void {
        echo "Processing PayPal payment of $$amount\n";
    }
    public function getPaymentType(): string { return "PayPal"; }
}

class StripePayment implements Payment {
    public function processPayment(float $amount): void {
        echo "Processing Stripe payment of $$amount\n";
    }
    public function getPaymentType(): string { return "Stripe"; }
}

class PayoneerPayment implements Payment {
    public function processPayment(float $amount): void {
        echo "Processing Payoneer payment of $$amount\n";
    }
    public function getPaymentType(): string { return "Payoneer"; }
}

class PaymentFactory {
    public static function createPayment(string $type): Payment {
        switch (strtolower($type)) {
            case 'paypal': return new PayPalPayment();
            case 'stripe': return new StripePayment();
            case 'payoneer': return new PayoneerPayment();
            default: throw new InvalidArgumentException("Unknown payment type: $type");
        }
    }
}

class PaymentLogger {
    private static $logFile = 'payment_logs.txt';

    public static function log(string $message): void {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] $message\n";
        file_put_contents(self::$logFile, $logEntry, FILE_APPEND | LOCK_EX);
        echo $logEntry;
    }

    public static function getLogs(): string {
        return file_exists(self::$logFile) ? file_get_contents(self::$logFile) : "No logs available.\n";
    }
}

class PaymentGateway {
    public function process(string $paymentType, float $amount): void {
        try {
            PaymentLogger::log("Attempting $paymentType payment of $$amount");
            $payment = PaymentFactory::createPayment($paymentType);
            $payment->processPayment($amount);
            PaymentLogger::log("SUCCESS: $paymentType payment of $$amount processed");
        } catch (Exception $e) {
            PaymentLogger::log("ERROR: $paymentType payment failed - " . $e->getMessage());
        }
    }
}

// Usage
$gateway = new PaymentGateway();
$gateway->process('paypal', 100.50);
$gateway->process('stripe', 75.25);
$gateway->process('payoneer', 200.00);

echo "\n=== FINAL LOGS ===\n";
echo PaymentLogger::getLogs();

?>
