<?php

namespace App\Utilitaire;

use App\Entity\Mariage;

class RestMariage
{

    public function __construct(){}

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

    public static function getUnMariage($client, $apiAdress, $apiServer, $idMariage)
    {
        $response = $client->request('GET', $apiAdress . 'mariages?id=' . $idMariage . '&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
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
        return $a;
    }
}
