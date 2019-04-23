<?php

namespace App\Controller\Admin;

use App\Entity\Options;
use App\Form\OptionsType;
use App\Repository\OptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/options")
 */
class AdminOptionsController extends AbstractController
{
    /**
     * @Route("/", name="admin.options.index", methods={"GET"})
     */
    public function index(OptionsRepository $optionsRepository): Response
    {
        return $this->render('admin/options/index.html.twig', [
            'options' => $optionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.options.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $option = new Options();
        $form = $this->createForm(optionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();
            
            $this->addFlash('success', 'Option ajouter avec succès');
            
            return $this->redirectToRoute('admin.options.index');
        }

        return $this->render('admin/options/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

   

    /**
     * @Route("/{id}/edit", name="admin.options.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Options $option): Response
    {
        $form = $this->createForm(optionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('success', 'Option modifié avec succès');
            
            return $this->redirectToRoute('admin.options.index', [
                'id' => $option->getId(),
            ]);
        }

        return $this->render('admin/options/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.options.delete", methods={"DELETE"})
     * @param Options $option
	 * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function delete(Options $option, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $option->getId(), $request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
            
            $this->addFlash('success', 'Option supprimé avec succès');
            
        }
        
        return $this->redirectToRoute('admin.options.index');
        
        
    }
}
