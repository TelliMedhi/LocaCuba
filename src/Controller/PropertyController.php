<?php

namespace App\Controller;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository,ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }
    /**
     * @Route("/locations", name="property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAllVisible();
      return $this->render('property/index.html.twig',[
            'current_menu'=>'properties',
             'properties' => $properties
        ]);
    }
    /**
     * @Route("/locations/{slug}-{id}", name="property.show",requirements={"id" = "\d+","slug": "[a-z0-9\-]*"})
     * @param Property $property
     */
    public function show( Property $property,string $slug)
    {
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show',[
                'id'=>$property->getId(),
                'slug'=>$property->getSlug()
            ],301);
        }
        return $this->render('property/show.html.twig',[
            'property'=>$property,
            'current_menu'=>'properties'
        ]);
    }

}
