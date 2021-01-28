<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * renvoie le nombre de prets pour un adhérent
	 * @Route(
	 *      path="API/categorie/{url}",
	 *      name="api_categorie",
	 *      methods={"GET"},
	 *      defaults={
	 *          "_controller"="\app\controller\AdherentController::nombrePrets",
	 *          "_api_resource_class"="App\Entity\Adherent",
	 *          "_api_item_operation_name"="getNbPrets"
	 *      }
	 * )
     */
    public function index(): Response
    {
        
    }
}
