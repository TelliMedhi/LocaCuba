<?php

namespace App\Controller;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin_property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setCreatedAt(new \DateTime());
            $manager->persist($property);
            $manager->flush();
            $this->addFlash('success','L\'annonce à été crée avec succès ');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin_property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit",methods="GET|POST")
     */
    public function edit(Property $property, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success','L\'annonce à été modifiée avec succès ');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin_property/edit.html.twig', [
            'properties' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/property/{id}", name="admin.property.delete",methods="DELETE")
     */

    public function delete(Property $property, ObjectManager $manager, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
            $manager->remove($property);
            $manager->flush();
            $this->addFlash('success','L\'annonce à été supprimée avec succès ');
        }

       return $this->redirectToRoute('admin.property.index');
    }
}

