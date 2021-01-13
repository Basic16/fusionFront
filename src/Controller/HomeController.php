<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utilitaire\RestMariage;
use App\Utilitaire\RestCategorie;
use App\Entity\Mariage;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

//use Symfony\Component\HttpClient\CurlHttpClient;

class HomeController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;//new CurlHttpClient();
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $mariages = RestMariage::getLesMariages($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));
        
        return $this->render('home/index.html.twig', ['mariages' => $mariages]);
    }
}
