<?php

class Price
{
    private ?int $id;
    private float $value;
    private Currency $currency;

    public function __construct(?int $id, float $value, Currency $currency)
    {
        $this->id = $id;
        $this->value = $value;
        $this->currency = $currency;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}