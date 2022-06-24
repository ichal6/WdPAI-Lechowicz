<?php

class Price
{
    private ?int $id;
    private string $name;
    private string $currency;

    public function __construct(?int $id, string $name, string $currency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}