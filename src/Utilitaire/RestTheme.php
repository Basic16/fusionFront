<?php
namespace App\Utilitaire;
use App\Entity\Theme;
use App\Utilitaire\RestCategorie;
use App\Utilitaire\Article;

class RestTheme {

    public function __construct(){}


    public static function getTheme($client, $apiAdress){

        $response = $client->request('GET', $apiAdress.'themes/1' , [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $articles = array();
        $t = new Theme();
        $t->setHeader($content['header']);
        $t->setFooter($content['footer']);

        return $t;

    }

}
