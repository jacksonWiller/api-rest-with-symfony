<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
     * @Route("/categories", name="categories_")
    */

    class CategoryController extends AbstractController
    {
        /**
         * @Route("/", name="list", methods={"GET"})
        */
        public function list()
        {
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
    
    
            return $this->json([
                'data' => $categories
            ]);
        }
    
        /**
         * @Route("/{categoryId}", name="show", methods={"GET"})
        */
        public function show($categoryId)
        {
            $product = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);
            
    
    
            return $this->json([
                'data' => $product
            ]);
        }
    
         /**
         * @Route("/", name="create", methods={"POST"})
        */
        public function create(Request $request)
        {
            $categoryData = $request->request->all();
    
            $category = new Category();
            $from = $this->createForm(CategoryType::class, $category);
            $from->submit($categoryData);
    
            $date = new \DateTime('@'.strtotime('now'));
            $date->format('Y-m-d H:i:s');
    
            $category->setCreatedAt($date);
            $category->setUpdatedAt($date);
    
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($category);
            $doctrine->flush();
    
            return $this->json([
                'message' => 'categoria criada com sucesso'
            ]);
        }
        
       /**
         * @Route("/{categoryId}", name="update", methods={"PUT"})
         */
        public function update(Request $resquest, $categoryId)
        {
    
            $categoryData = $resquest->request->all();
    
            $doctrine = $this->getDoctrine();
    
            $category = $doctrine->getRepository(Category::class)->find($categoryId);
            
            $from = $this->createForm(CategoryType::class, $category);
            $from->submit($categoryData);
            
            $date = new \DateTime('@'.strtotime('now'));
            $date->format('Y-m-d H:i:s');

            $category->setCreatedAt($date);
            $category->setUpdatedAt($date);
            
            $manager = $doctrine->getManager();
            $manager->persist($category);
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
    
            $category = $doctrine->getRepository(Category::class)->find($categoryId);
            
            
            $manager = $doctrine->getManager();
    
            $manager->persist($category);
            $manager->remove($category);
            $manager->flush();
    
            return $this->json([
                'message' => 'Usuario Deletado com sucesso!',
            ]);
        } 
        
    }