<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/connexion", name="user_connexion")
     */
    public function login()
    {

        return $this->render('user/connexion.html.twig');
    }
    /**
     * @Route("/inscription", name="user_registration")
     */
    public function registration(Request $request,ObjectManager $manager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        return $this->render('user/registration.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
