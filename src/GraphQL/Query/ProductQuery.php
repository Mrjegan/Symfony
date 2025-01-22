<?php

namespace App\GraphQL\Query;

use App\Repository\ProductRepository;

class ProductQuery
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }
}
