<?php
namespace App\GraphQL\Mutation;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductMutation
{
    private $entityManager;
    private $productRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    public function createProduct($name, $description, $price)
    {
        // Create a new product
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);

        // Persist product to the database
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;  // Return the created product
    }
}
