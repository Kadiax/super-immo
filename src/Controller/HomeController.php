<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends  AbstractController
{
	
	/**
	 * @Route("/", name="home")
	 * @param PropertyRepository $repository
	 * @return Response
	 */
    public function index(PropertyRepository $repository): Response
	{
	    $properties = $repository->findLatest();
	    $slide_prop = $repository->findPrevious();
	    //dump($property);
		return $this->render('pages/home.html.twig',[
		    'properties' => $properties,
		    'current_menu' => 'home',
		    'slide_prop' => $slide_prop
		]);
	}
	
	/**
	 * @Route("/about", name="about")
	 * @return Response
	 */
	public function about(): Response
	{
	    //dump($property);
	    return $this->render('pages/about.html.twig',[
	        'current_menu' => 'about'
	    ]);
	}
	
	/**
	 * @Route("/contact", name="contact")
	 * @return Response
	 */
	public function contact(): Response
	{
	    //dump($property);
	    return $this->render('pages/contact.html.twig',[
	        'current_menu' => 'contact'
	    ]);
	}
}