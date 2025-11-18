<?php
namespace App;

class Product
{
    public array $details = [];
    public array $variants = [];
    public array $shippingMethods = [];
}

class ProductBuilder
{
    public Product $product;

    public static function builder(): self
    {
        $builder = new self();
        $builder->product = new Product();
        return $builder;
    }

    public function setDetails(array $details): self
    {
        $this->product->details = $details;
        return $this;
    }

    public function setVariants(array $variants): self
    {
        $this->product->variants = $variants;
        return $this;
    }

    public function setShippingMethods(array $shippingMethods): self
    {
        $this->product->shippingMethods = $shippingMethods;
        return $this;
    }

    public function build(): Product
    {
        return $this->product;
    }
}

// Usage
$product = ProductBuilder::builder()
    ->setDetails(['name' => 'Laptop', 'price' => 1500])
    ->setVariants(['16GB RAM', '32GB RAM'])
    ->setShippingMethods(['DHL', 'FedEx'])
    ->build();

print_r($product);
