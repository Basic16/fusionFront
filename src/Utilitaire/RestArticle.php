<?php
namespace App\Utilitaire;
use App\Entity\Article;
use App\Utilitaire\RestCategorie;
use App\Utilitaire\RestAvis;

class RestArticle {

    public function __construct(){}


    public static function getLesArticles($client, $apiAdress, $apiServer){

                $response = $client->request('GET', $apiAdress.'articles' , [
                    'headers' => [
                    'Accept' => 'application/json',
                    ],
                    ]);
                $statusCode = $response->getStatusCode();
                $content = $response->toArray();
                $articles = array();
                foreach($content as $unArticle) {
                    $a = new Article();
                    $a->setId($unArticle['id']);
                    $a->setTitre($unArticle['titre']);
                    $a->setContenu($unArticle['contenu']);
                    $date = new \DateTime($unArticle['date']);
                    $a->setDate($date);
                    $a->setUrl($unArticle['url']);
                    $a->setExtrait($unArticle['extrait']);
                    if (isset($unArticle['image'])) {
                        $a->setImage($unArticle['image']);
                    }
                    $categorie = RestCategorie::getLaCategorie($client, $apiServer, $unArticle['categorie']);
                    $a->setCategorie($categorie);
                    $articles[] = $a;

                }
                return $articles;


}

    public static function getUnArticle($client, $apiAdress, $apiServer, $pathArticle){

            $response = $client->request('GET', $apiAdress.'articles?url='.$pathArticle.'&page=1' , [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
            dump($apiAdress.'articles?url='.$pathArticle.'&page=1');
            $statusCode = $response->getStatusCode();
            $content = $response->toArray();
            dump($content);
            $a = new Article();
            $a->setId($content[0]['id']);
            $a->setTitre($content[0]['titre']);
            $a->setContenu($content[0]['contenu']);
            $date = new \DateTime($content[0]['date']);
            $a->setDate($date);
            $a->setUrl($content[0]['url']);
            $a->setExtrait($content[0]['extrait']);
            if (isset($content[0]['image'])){
                $a->setImage($content[0]['image']);
            }
            $categorie = RestCategorie::getLaCategorie($client, $apiServer, $content[0]['categorie']);
            $a->setCategorie($categorie);
            $array = array();
            $avis = RestAvis::getUnAvis($client, $apiServer, $content[0]['avis'][0]);
            $array[] = $avis;
            $avisDeux = RestAvis::getUnAvis($client, $apiServer, $content[0]['avis'][1]);
            $array[]=$avisDeux;
            dump($array);
            $a->setAvis($avis);
            $article = $a;
            return $article;

        }

    public static function getLarticle($client, $apiServer , $apiAdress, $pathArticle){
        dump($pathArticle);

        $response = $client->request('GET', $apiServer.$pathArticle , [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        dump($content);
        $a = new Article();
        $a->setId($content['id']);
        $a->setTitre($content['titre']);
        $a->setContenu($content['contenu']);
        $date = new \DateTime($content['date']);
        $a->setDate($date);
        $a->setUrl($content['url']);
        $a->setExtrait($content['extrait']);
        if (isset($content['image'])){
            $a->setImage($content['image']);
        }
        $categorie = RestCategorie::getLaCategorie($client, $apiServer, $content['categorie']);
        $a->setCategorie($categorie);
        $article = $a;

        return $article;



    }

    public static function searchArticle($client, $apiAdress, $apiServer, $pathArticle){

        $response = $client->request('GET', $apiAdress.'articles?titre='.$pathArticle.'&page=1' , [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $articles = array();
        dump($apiAdress.'articles?titre='.$pathArticle.'&page=1');
        foreach($content as $unArticle){
            $a = new Article();
            $a->setId($unArticle['id']);
            $a->setTitre($unArticle['titre']);
            $a->setContenu($unArticle['contenu']);
            $date = new \DateTime($unArticle['date']);
            $a->setDate($date);
            $a->setUrl($unArticle['url']);
            $a->setExtrait($unArticle['extrait']);
            if (isset($unArticle['image'])){
                $a->setImage($unArticle['image']);
            }
            $categorie = RestCategorie::getLaCategorie($client, $apiServer, $unArticle['categorie']);
            $a->setCategorie($categorie);
            $articles[] = $a;
        }
        return $articles;


    }




}
