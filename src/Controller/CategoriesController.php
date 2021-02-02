<?php

namespace App\Controller;

use App\Utilitaire\RestListingCategory;
use App\Utilitaire\RestMariage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CategoriesController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/categories/{url}", name="categories", requirements={"d"="en|fr"})
     */
    public function index(String $url, Request $request): Response
    {
        // GET url listing catégorie value in url
        $listingsCategories = RestListingCategory::getUnListingCategorie($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $url);

        // Get list mariages
        $mariages = RestMariage::getLesMariages($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        dump($listingsCategories);

        return $this->render('categories/index.html.twig', [
            'data' => $listingsCategories,
            'mariages' => $mariages,
            'controller_name' => 'CategoriesController',
        ]);
    }
}
