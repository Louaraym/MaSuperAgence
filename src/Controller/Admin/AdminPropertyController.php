<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**

     * @var ObjectManager
     */
    private $manager;

    public function __construct(PropertyRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="admin.property.index")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,  PaginatorInterface $paginator): Response
    {
        $properties = $paginator->paginate(
           $properties = $this->repository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/property/new", name="admin.property.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $this->manager->persist($property);
            $this->manager->flush();
            $this->addFlash('success', 'Votre Ajout a été effectué avec succès !');
            return  $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
          /*  if ($property->getImageFile() instanceof UploadedFile){
                $cacheManager->remove($uploaderHelper->asset($property, 'imageFile'));
            }*/
            $this->manager->flush();
            $this->addFlash('success', 'Votre modification a été effectuée avec succès !');
            return  $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/property/{id}", name="admin.property.delete", methods= "DELETE")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function delete(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){

                $this->manager->remove($property);
                $this->manager->flush();
                $this->addFlash('success', 'Votre suppression a été effectuée avec succès !');
        }

          return  $this->redirectToRoute('admin.property.index');

    }
}
