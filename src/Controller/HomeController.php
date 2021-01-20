<?php

namespace App\Controller;

use App\Utilitaire\RestListingCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utilitaire\RestMariage;
use App\Utilitaire\RestUser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        // Permet l'affichage des styles de mariages
        $mariages = RestMariage::getLesMariages($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        // Permet l'affichage des Top Wedder
        $categories = RestListingCategory::getLesListinCategory($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));
        //$categories = [];
        // Permet l'affichage des dernier Wedder
        $wedders = RestUser::getLesWedders($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        dump($wedders);
        dump($categories);
        return $this->render('home/index.html.twig', ['mariages' => $mariages, 'categories' => $categories, 'wedders' => $wedders]);
    }


}
