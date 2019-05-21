<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Options;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AdminPropertyController extends  AbstractController
{
    /**
     * 
     * @var PropertyRepository $repository
     */
    private $repository;
    /**
     * 
     * @var ObjectManager $em
     */
    private $em;
    
     public function __construct(PropertyRepository $repository, ObjectManager $em) {
         $this->repository=$repository;
         $this->em=$em;
     }
    
	/**
	 * @Route("/admin/property", name="admin.property.index")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    
     public function index(PaginatorInterface $paginator, Request $request): Response
	{  
	    //pagination
	    $properties = $paginator->paginate($this->repository->findAllQuery(),
	        $request->query->getInt('page', 1), /*page number*/
	        15 /*limit per page*/
	        );
	    
	    return $this->render('admin/property/index.html.twig', [
	        'properties' => $properties
	    ]);
	}
	
	/**
	 * @Route("/admin/property/create", name="admin.property.new")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function new(Request $request)
	{
	    $property = new Property();
	    $form = $this->createForm(PropertyType::class, $property);
	    $form->handleRequest($request);
	    
	    if($form->isSubmitted() && $form->isValid())
	    {
	        $this->em->persist($property);
	        $this->em->flush();
	        $this->addFlash('success', 'Bien ajouter avec succès');
	        return $this->redirectToRoute('admin.property.index');
	    }
	    
	    return $this->render('admin/property/new.html.twig',
	        [
	            'property' => $property,
	            'form' => $form->createView()
	        ]);
	}
	
	/**
	 * @Route("/admin/property/{id}", name="admin.property.edit")
	 * @param Property $property
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function edit(Property $property, Request $request)
	{
	    
	    //Formulaire edit
	    $form = $this->createForm(PropertyType::class, $property);
	    $form->handleRequest($request);
	    
	    if($form->isSubmitted() && $form->isValid())
	    {
	        $this->em->flush();
	        $this->addFlash('success', 'Bien modifié avec succès');
	        return $this->redirectToRoute('admin.property.index');
	        
	    }
	    return $this->render('admin/property/edit.html.twig', 
	       [
	           'property' => $property,
	           'form' => $form->createView()
	       ]);
	}
	
	/**
	 * @Route("/admin/property/delete/{id}", name="admin.property.delete", methods="DELETE")
	 * @param Property $property
	 * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Property $property, Request $request)
	{
	    if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
	    {
	         $this->em->remove($property);
	         $this->em->flush();
	         $this->addFlash('success', 'Bien supprimé avec succès');
	         
	    }
	   
	    return $this->redirectToRoute('admin.property.index');
	    
	   
	}

}