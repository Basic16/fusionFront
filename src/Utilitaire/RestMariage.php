<?php
namespace App\Utilitaire;
use App\Entity\Mariage;
class RestMariage {

    public function __construct(){}

    public static function getLesMariages($client, $apiAdress, $apiServer){
                $response = $client->request('GET', $apiAdress.'mariages' , [
                    'headers' => [
                    'Accept' => 'application/json',
                    ],
                    ]);
                    

                $statusCode = $response->getStatusCode();
                $content = $response->toArray();
                $mariages = array();
                foreach($content as $unMariage){
                    $a = new Mariage();
                    $a->setId($unMariage['id']);
                    $a->setNom($unMariage['nom']);
                    $a->setText($unMariage['text']);
                    $a->setUrl($unMariage['url']);
                    $a->setTraduction($unMariage['traduction']);
                    $a->setTLogo($unMariage['logo']);
                    $a->setImageaccueil($unMariage['imageaccueil']);
                    if (isset($unMariage['images'])){
                        $a->setImages($unMariage['images']);
                    }
                    $mariages[] = $a;
                }
                return $mariages;


}
/*
    public static function getUnArticle($client, $apiAdress, $apiServer, $pathArticle){

            $response = $client->request('GET', $apiAdress.'articles?url='.$pathArticle.'&page=1' , [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
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
            $article = $a;

            return $article;

        }*/




}
