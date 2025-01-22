<?php

namespace App\GraphQL\Query;

use App\Repository\ProductRepository;

class Query
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): array
    {
        // Fetch all products from the repository
        return $this->productRepository->findAll();
    }
}
