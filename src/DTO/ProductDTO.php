<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $code;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $description;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $image;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $category;

    #[Assert\NotNull]
    #[Assert\Type(type: "float")]
    #[Assert\PositiveOrZero]
    public float $price;

    #[Assert\NotNull]
    #[Assert\Type(type: "integer")]
    #[Assert\PositiveOrZero]
    public int $quantity;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $internalReference;

    #[Assert\NotNull]
    #[Assert\Type(type: "integer")]
    public int $shellId;

    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    #[Assert\Choice(choices: ["INSTOCK", "LOWSTOCK", "OUTOFSTOCK"], message: "Please choose a valid status !")]
    public string $inventoryStatus;

    #[Assert\NotNull]
    #[Assert\Type(type: "integer")]
    #[Assert\Range(min: 0, max: 5)]
    public int $rating;
}