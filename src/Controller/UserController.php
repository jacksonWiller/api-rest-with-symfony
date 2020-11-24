<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

    /**
     * @Route("/users", name="users_")
    */

class UserController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
    */
    public function list()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();


        return $this->json([
            'data' => $users
        ]);
    }

    /**
     * @Route("/{userId}", name="show", methods={"GET"})
    */
    public function show($userId)
    {
        $product = $this->getDoctrine()->getRepository(User::class)->find($userId);
        


        return $this->json([
            'data' => $product
        ]);
    }

     /**
     * @Route("/", name="create", methods={"POST"})
    */
    public function create(Request $request)
    {
        $userData = $request->request->all();

        $user = new User();
        $from = $this->createForm(UserType::class, $user);
        $from->submit($userData);

        $date = new \DateTime('@'.strtotime('now'));
        $date->format('Y-m-d H:i:s');

        $user->setIsActive(true);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($user);
        $doctrine->flush();

        return $this->json([
            'message' => 'usuario criado com sucesso'
        ]);
    }
    
   /**
     * @Route("/{userId}", name="update", methods={"PUT"})
     */
    public function update(Request $resquest, $userId)
    {

        $userData = $resquest->request->all();

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);
        
        $from = $this->createForm(UserType::class, $user);
        $from->submit($userData);
        
        $date = new \DateTime('@'.strtotime('now'));
        $date->format('Y-m-d H:i:s');
        $user->setIsActive(true);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);
        
        $manager = $doctrine->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->json([
            'message' => 'Usuario Atualizado com sucesso!',
        ]);
    } 

    /**
     * @Route("/{userId}", name="delete", methods={"DELETE"})
     */
    public function delete($userId)
    {

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);
        
        
        $manager = $doctrine->getManager();

        $manager->persist($user);
        $manager->remove($user);
        $manager->flush();

        return $this->json([
            'message' => 'Usuario Deletado com sucesso!',
        ]);
    } 
    

    

}
