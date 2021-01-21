<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\Mariage;

class RestMariage
{

    public function __construct(){}

    /**
     * Récupère tout les type de mariage
     */
    public static function getLesMariages($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'mariages', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $mariages = array();
        foreach ($content as $unMariage) {
            $a = new Mariage();
            $a->setId($unMariage['id']);
            $a->setNom($unMariage['nom']);
            $a->setText($unMariage['texte']);
            $a->setImages($unMariage['image']);
            //$a->setUrl($unMariage['url']);
            $a->setTraduction($unMariage['traduction']);
            //$a->setLogo($unMariage['logo']);
            $a->setImageaccueil($unMariage['imageaccueil']);
            if (isset($unMariage['images'])) {
                $a->setImages($unMariage['images']);
            }
            $mariages[] = $a;
        }
        return $mariages;
    }

    /*
        Récupère les information ainsi que les listing d'un mariage en particulier
     */
    public static function getUnMariage($client, $apiAdress, $apiServer, $nameMariage)
    {
        $response = $client->request('GET', $apiAdress . 'mariages?nom=' . $nameMariage . '&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);


        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        dump($content);
        $a = new Mariage();
        $a->setId($content[0]['id']);
        $a->setNom($content[0]['nom']);
        $a->setText($content[0]['texte']);
        $a->setImages($content[0]['image']);
        //$a->setUrl($unMariage['url']);
        $a->setTraduction($content[0]['traduction']);
        //$a->setLogo($unMariage['logo']);
        $a->setImageaccueil($content[0]['imageaccueil']);
        if (isset($content[0]['images'])) {
            $a->setImages($content[0]['images']);
        }

        $listListing = [];
        foreach ($content[0]["listings"] as $l) {
            $listing = new Listing();
        }

        
        return $a;
    }
}
