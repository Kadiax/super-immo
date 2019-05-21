<?php
namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomeController extends  AbstractController
{
	
	/**
	 * @Route("/admin", name="admin.index")
	 * @param PropertyRepository $repository
	 * @return Response
	 */
    public function index(PropertyRepository $repository): Response
	{

	    //dump($property);
		return $this->render('admin/admin.index.html.twig',[
		    'current_menu' => 'admin'
		]);
	}
	
	
}