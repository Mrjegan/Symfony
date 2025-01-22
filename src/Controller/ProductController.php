<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="get_products", methods={"GET"})
     */
    public function getAll(
        ProductRepository $productRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $products = $productRepository->findAll();
        if (empty($products)) {
            return $this->json(['error' => 'No products found'], Response::HTTP_NOT_FOUND);
        }
        $json = $serializer->serialize($products, 'json', ['groups' => 'product:read']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/products/{id}", name="get_product", methods={"GET"})
     */
    public function get(
        int $id,
        ProductRepository $productRepository
    ): JsonResponse {
        $product = $this->findProductOr404($id, $productRepository);
        return $this->json($product, Response::HTTP_OK, [], ['groups' => 'product:read']);
    }

    /**
     * @Route("/api/products", name="create_product", methods={"POST"})
     */
    public function create(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['description'], $data['price'])) {
            return new JsonResponse(
                ['error' => 'Missing required fields: name, description, price'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);

        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            return new JsonResponse(
                ['errors' => (string) $errors],
                Response::HTTP_BAD_REQUEST
            );
        }

        $em->persist($product);
        $em->flush();

        $json = $serializer->serialize($product, 'json', ['groups' => 'product:read']);
        return new JsonResponse($json, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/api/products/{id}", name="update_product", methods={"PUT"})
     */
    public function update(
        int $id, 
        Request $request, 
        ProductRepository $productRepository, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator
    ): JsonResponse
    {
        $product = $productRepository->find($id);
    
        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }
    
        $data = json_decode($request->getContent(), true);
    
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
    
        $errors = $validator->validate($product);
    
        if (count($errors) > 0) {
            return new JsonResponse(
                ['errors' => (string) $errors],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        $em->flush();
    
        return $this->json($product, Response::HTTP_OK);
    }

    /**
     * @Route("/api/products/{id}", name="delete_product", methods={"DELETE"})
     */
    public function delete(
        int $id,
        ProductRepository $productRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        $product = $this->findProductOr404($id, $productRepository);

        $em->remove($product);
        $em->flush();

        return $this->json(['status' => 'success', 'message' => 'Product deleted'], Response::HTTP_OK);
    }

    private function findProductOr404(
        int $id,
        ProductRepository $productRepository
    ): Product {
        $product = $productRepository->find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product;
    }
}
