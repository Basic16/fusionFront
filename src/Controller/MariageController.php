<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Utilitaire\RestMariage;
use App\Utilitaire\RestUser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MariageController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/mariage", name="mariage")
     */
    public function mariage(Request $request): Response
    {
        // GET idMariage value in url
        $idMariage =  $request->query->get('id');

        // GET mariage info
        $mariage = RestMariage::getUnMariage($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $idMariage);

        // GET wedder list
        $wedders = RestUser::getLesWedders($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        return $this->render('mariage/index.html.twig', [
            'mariage' => $mariage,
            'wedders' => $wedders,    
            'controller_name' => 'MariageController',
        ]);
    }
}
