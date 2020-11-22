<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProductController.php',
        ]);
    }

    /**
     * @Route("/product", name="product", methods={"POST"})
     */
    public function create(Request $resquest)
    {

        $date = new \DateTime('@'.strtotime('now'));
        $date->format('Y-m-d H:i:s');

        $productData = $resquest->request->all();

        $product = new Product();
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setContent($productData['content']);
        $product->setPrice($productData['price']);
        $product->setSlug($productData['slug']);
        $product->setIsActive(true);
        $product->setCreatedAt($date);
        $product->setUpdatedAt($date);
        
        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->persist($product);
        $doctrine->flush();

        return $this->json([
            'message' => 'Produto criado com sucesso!',
        ]);
    }

}
