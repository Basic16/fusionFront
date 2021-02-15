<?php

namespace App\Utilitaire;
use App\Entity\Categorie;
use App\Entity\Article;

class RestCategorie
{
    public function __construct()
    {
    }

    public static function getLaCategorieId($client, $apiAdress, $idCat){
        dump($apiAdress);
        $response = $client->request('GET', $apiAdress.'categories/'.$idCat, [
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

    public static function getUneCategorieParId($client, $apiAdress, $idCat)
    {
        $response = $client->request('GET', $apiAdress.'categories/'.$idCat, [
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


    public static function getLaCategorie($client, $apiAdress, $idCat){
        $response = $client->request('GET', $apiAdress.$idCat, [
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

    public static function getCatNbArticles($client, $apiAdress, $apiServer)
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
            foreach($uneCat['articles'] as $unArticle){
                dump($unArticle);
                $article = RestArticle::getLarticle($client, $apiServer, $apiAdress, $unArticle);
                $c->addArticle($article);
            }
            $categories[] = $c;
        }
        return $categories;
    }



    public static function deleteCat($client, $apiAdress, $apiServer, $idCat){

        $client->request('DELETE', $apiAdress.'categories/'.$idCat , [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }




    public static function createCategorie($client, $apiAdress, $categorie){
        $libelle = $categorie->getLibelle();
        $articles = [];
        $response = $client->request('POST', $apiAdress.'categories', [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                'Accept' => 'application/json',
            ],
            'json' => ['libelle' => $libelle, 'articles' => $articles],
        ]);

        $statusCode = $response->getStatusCode();
        return $statusCode;
    }


    public static function getArticlesByCat($client, $apiAdress, $apiServer, $pathCat){
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

    public static function getCatLibelle($client, $apiAdress, $pathCat){
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
    public static function getVerifArticle($client, $apiAdress, $idCat)
    {
        $response = $client->request('GET', $apiAdress.'categories/'.$idCat, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        if ($content['articles']==null){
            $verifArticle = false;
            dump($verifArticle);
        }
        else{
            $verifArticle = true;
            dump($verifArticle);
        }
        return $verifArticle;
    }

    public function test($client){
        $response = $client->request('GET', 'https://app.360learning.com/api/v1/programs/sessions/?company=5e453b3dbcf312329bd393f6&apiKey=75f9eaac5fcb4856a21c873b2045d36e', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $content = $response->toArray();
        return $content;
    }
}
