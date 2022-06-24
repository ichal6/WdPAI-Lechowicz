<?php

class ListShop
{
    private int $id;
    private string $title;
    private int $owner_id;
    private ?Category $category = null;
    private ?Priority $priority = null;
    private Type $type;

    public function __construct(int $owner_id, string $title,
                                Type $type)
    {
        $this->owner_id = $owner_id;
        $this->title = $title;
        $this->type = $type;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function setPriority(Priority $priority): void
    {
        $this->priority = $priority;
    }



}
