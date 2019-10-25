<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     */

    public function index(PropertyRepository $repository, ObjectManager $manager)
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
           'properties'=> $properties
        ]);
    }
}
