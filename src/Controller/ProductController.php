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
     * @Route("/product", name="show_products", methods={"GET"})
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();


        return $this->json([
            'data' => $products
        ]);
    }

    /**
     * @Route("/product/{productId}", name="show_products", methods={"GET"})
     */
    public function show($productId)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);


        return $this->json([
            'data' => $product
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


    /**
     * @Route("/product", name="update_product", methods={"PUT"})
     */
    public function update(Request $resquest)
    {   

        

        $date = new \DateTime('@'.strtotime('now'));
        $date->format('Y-m-d H:i:s');

        $productData = $resquest->request->all();

        $doctrine = $this->getDoctrine();

        $product = $doctrine->getRepository(Product::class)->find($productId);
        
        $doctrine = $this->getDoctrine()->getManager();

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


    /**
     * @Route("/product/{productId}", name="delete_product", methods={"DELETE"})
     */
    public function remove($productId)
    {

        $doctrine = $this->getDoctrine();

        $product = $doctrine->getRepository(Product::class)->find($productId);
        
        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->persist($product);
        $doctrine->flush();

        return $this->json([
            'message' => 'Produto deletado com sucesso!',
        ]);
    }

}
