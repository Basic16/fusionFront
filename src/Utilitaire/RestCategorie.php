<?php

namespace App\Utilitaire;
use App\Entity\Categorie;

class RestCategorie
{
    public function __construct()
    {
    }
    public static function getLaCategorie($client, $apiAdress, $pathCat)
    {
        $response = $client->request('GET', $apiAdress.$pathCat, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $categorie = new Categorie();
        $categorie->setId($content['id']);
        $categorie->setLibelle($content['libelle']);
        
        return $categorie;
    }

    public static function getLesCategories($client, $apiAdress)
    {
        $response = $client->request('GET', $apiAdress.'categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $content = $response->toArray();
        foreach ($content as $uneCat) {
            $c = new Categorie();
            $c->setId($uneCat['id']);
            $c->setLibelle($uneCat['libelle']);

            $categories[] = $c;
        }
        return $categories;
    }

    public static function getArticlesByCat($client, $apiAdress, $apiServer, $pathCat)
    {
        $response = $client->request('GET', $apiAdress.'categories?libelle='.$pathCat.'&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        dump($apiAdress.'categories?libelle='.$pathCat.'&page=1');
        $content = $response->toArray();
        dump($content);
        $articles = array();
        foreach ($content[0]['articles'] as $uriArticle) {

            $article = RestArticle::getLarticle($client, $apiServer, $apiAdress, $uriArticle);
            $articles[] = $article;

        }
        return $articles;
    }

    public static function getCatLibelle($client, $apiAdress, $pathCat)
    {
        $response = $client->request('GET', $apiAdress.'categories?libelle='.$pathCat.'&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        dump($apiAdress.'categories?libelle='.$pathCat.'&page=1');
        $content = $response->toArray();
        dump($content);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $categorie = new Categorie();
        $categorie->setId($content[0]['id']);
        $categorie->setLibelle($content[0]['libelle']);
        return $categorie;


    }




}
