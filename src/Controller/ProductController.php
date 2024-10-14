<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ProductController extends AbstractController
{
    private ProductService $productService;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(ProductService $productService, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->productService = $productService;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function createProduct(Request $request): JsonResponse
    {
        $productDTO = $this->serializer->deserialize($request->getContent(), ProductDTO::class, 'json');

        $errors = $this->validator->validate($productDTO);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $createdProduct = $this->productService->createProduct($productDTO);

        return $this->json($createdProduct, Response::HTTP_CREATED);
    }

    public function getAllProducts(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return $this->json($products);
    }

    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($product);
    }

    public function updateProduct(int $id, Request $request): JsonResponse
    {
        $productDTO = $this->serializer->deserialize($request->getContent(), ProductDTO::class, 'json');

        $errors = $this->validator->validate($productDTO);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $updatedProduct = $this->productService->updateProduct($id, $productDTO);

        return $this->json($updatedProduct);
    }

    public function deleteProduct(int $id): JsonResponse
    {
        $deleted = $this->productService->deleteProduct($id);
        if (!$deleted) {
            return $this->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'Product deleted'], Response::HTTP_NO_CONTENT);
    }
}