<?php

class Product
{
    private ?int $id;
    private string $name;
    private ?string $available;
    private Status $status;
    private float $quantity;
    private Unit $unit;
    private ?Price $price;

    public function __construct(?int $id, string $name, ?string $available, Status $status, float $quantity, Unit $unit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->available = $available;
        $this->status = $status;
        $this->quantity = $quantity;
        $this->unit = $unit;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvailable(): ?string
    {
        return $this->available;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): void
    {
        $this->price = $price;
    }


}