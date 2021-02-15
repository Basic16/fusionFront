<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Utilitaire\RestArticle;
use App\Utilitaire\RestUser;
use App\Utilitaire\RestTheme;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DashboardController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        //$theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        $lesUsers = RestUser::getLesUsers($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        $lesWedders = RestUser::getLesWedders($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        $month = RestUser::getLastMonth($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        $week = RestUser::getLastWeek($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));

        return $this->render('dashboard/index.html.twig', 
        [
            //'theme'=>$theme,
            'lesUsers'=>$lesUsers,
            'lesWedders'=>$lesWedders, 
            'lastMonth' => $month,
            'lastWeek' => $week
        ]);
    }

    /**
     * @Route("/chartCreator", name="chartCreator")
     */
    public function chartCreator(): Response
    {
        
       

        return $this->render('dashboard/chartCreator.html.twig', 
        [
        
        ]);
    }
}
