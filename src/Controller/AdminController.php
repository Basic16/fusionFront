<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Utilitaire\RestArticle;
use App\Utilitaire\RestUser;
use App\Utilitaire\RestTheme;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdminController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        $lesUsers = RestUser::getLesUsers($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        $lesWedders = RestUser::getLesWedders($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        $lesNonWedders = RestUser::getLesNonWedders($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'));
        
        dump($lesUsers);
        return $this->render('admin/index.html.twig', 
        [
            'theme'=>$theme,
            'lesUsers'=>$lesUsers,
            'lesWedders'=>$lesWedders,
            'lesNonWedders'=>$lesNonWedders,
            
        ]);
    }
}
