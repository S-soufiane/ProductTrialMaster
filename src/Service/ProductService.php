<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\DTO\ProductDTO;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(ProductDTO $data): Product
    {
        $product = new Product();
        $this->hydrateProduct($product, $data);
        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());
        $this->productRepository->save($product);
        return $product;
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->findAllProducts();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function updateProduct(int $id, ProductDTO $data): ?Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            return null;
        }

        $this->hydrateProduct($product, $data);
        $product->setUpdatedAt(new \DateTime());
        $this->productRepository->update();
        return $product;
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            return false;
        }

        $this->productRepository->delete($product);
        return true;
    }

    private function hydrateProduct(Product $product, ProductDTO $data): void
    {
        $product->setCode($data->code);
        $product->setName($data->name);
        $product->setDescription($data->description);
        $product->setImage($data->image);
        $product->setCategory($data->category);
        $product->setPrice($data->price);
        $product->setQuantity($data->quantity);
        $product->setInternalReference($data->internalReference);
        $product->setShellId($data->shellId);
        $product->setInventoryStatus($data->inventoryStatus);
        $product->setRating($data->rating);
    }
}