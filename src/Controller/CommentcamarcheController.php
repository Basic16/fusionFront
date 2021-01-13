<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentcamarcheController extends AbstractController
{
    /**
     * @Route("/commentcamarche", name="commentcamarche")
     */
    public function index(): Response
    {
        return $this->render('commentcamarche/C.html.twig', [
            'controller_name' => 'CommentcamarcheController',
        ]);
    }
}
