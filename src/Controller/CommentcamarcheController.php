<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentcamarcheController extends AbstractController
{
    /**
     * @Route("/comment-ca-marche", name="comment-ca-marche")
     */
    public function Commentcamarche(): Response
    {
        return $this->render('commentcamarche/Comment-ca-marche.html.twig', [
            'controller_name' => 'CommentcamarcheController',
        ]);
    }


    /**
     * @Route("/qui-sommes-nous", name="qui-sommes-nous")
     */
    public function Quisommesnous(): Response
    {
        return $this->render('commentcamarche/Qui-sommes-nous.html.twig', [
            'controller_name' => 'CommentcamarcheController',
        ]);
    }


    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function Mentionslegales(): Response
    {
        return $this->render('commentcamarche/Mentions-legales.html.twig', [
            'controller_name' => 'CommentcamarcheController',
        ]);
    }

}
