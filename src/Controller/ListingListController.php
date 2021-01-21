<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Utilitaire\RestMariage;
use App\Utilitaire\RestUser;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ListingListController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/annonceur/{name}", name="listingList",  requirements={"d"="en|fr"})))
     */
    public function listingList(String $name, Request $request): Response
    {

        // GET idMariage value in url
        $mariage = RestMariage::getUnMariage($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $name);

        //dump($mariage);

        // GET wedder list
        $wedders = RestUser::getLesWedders($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        return $this->render('mariage/index.html.twig', [
            'mariage' => $mariage,
            'wedders' => $wedders,    
            'controller_name' => 'MariageController',
        ]);
    }
}
