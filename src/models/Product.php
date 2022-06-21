<?php

class Product
{
    private int $id;
    private string $name;
    private string $available;
    private string $status;
    private int $quantity;
    private string $unit;

    public function __construct(int $id, string $name, string $available, string $status, int $quantity, string $unit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->available = $available;
        $this->status = $status;
        $this->quantity = $quantity;
        $this->unit = $unit;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvailable(): string
    {
        return $this->available;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}