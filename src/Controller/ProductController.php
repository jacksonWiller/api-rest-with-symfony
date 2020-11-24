<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
    * @Route("/product", name="product_")
*/

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->json([
            'data' => $products
        ],200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
            return $object->getName();
        }]);
    }

    /**
     * @Route("/{productId}", name="show", methods={"GET"})
     */
    public function show($productId)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);


        return $this->json([
            'data' => $product
        ]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $resquest)
    {

        $productData = $resquest->request->all();

        $product = new Product();
        $from = $this->createForm(ProductType::class, $product);
        $from->submit($productData);
        
        $date = new \DateTime('@'.strtotime('now'));
        $date->format('Y-m-d H:i:s');
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
         * @Route("/{productId}", name="update", methods={"PUT"})
         */
        public function update(Request $resquest, $productId)
        {
    
            $productData = $resquest->request->all();
    
            $doctrine = $this->getDoctrine();
    
            $product = $doctrine->getRepository(Product::class)->find($productId);
            
            $from = $this->createForm(ProductType::class, $product);
            $from->submit($productData);
            
            $date = new \DateTime('@'.strtotime('now'));
            $date->format('Y-m-d H:i:s');

            $product->setCreatedAt($date);
            $product->setUpdatedAt($date);
            
            $manager = $doctrine->getManager();
            $manager->persist($product);
            $manager->flush();
    
            return $this->json([
                'message' => 'Usuario Atualizado com sucesso!',
            ]);
        } 
    
        /**
         * @Route("/{categoryId}", name="delete", methods={"DELETE"})
         */
        public function delete($categoryId)
        {
    
            $doctrine = $this->getDoctrine();
    
            $category = $doctrine->getRepository(Product::class)->find($categoryId);
            
            
            $manager = $doctrine->getManager();
    
            $manager->persist($category);
            $manager->remove($category);
            $manager->flush();
    
            return $this->json([
                'message' => 'Usuario Deletado com sucesso!',
            ]);
        } 
    

}
