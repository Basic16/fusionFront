<?php

namespace App\Utilitaire;
use App\Entity\Avis;

class RestAvis
{
    public function __construct()
    {
    }

    public static function getLesAvis($client, $apiAdress)
    {
        $response = $client->request('GET', $apiAdress.'avis', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $content = $response->toArray();

        foreach ($content as $unAvis) {
            $c = new Avis();

            $c->setId($unAvis['id']);
            $c->setTitre($unAvis['titre']);
            $c->setCommentaire($unAvis['commentaire']);
            $date = new \DateTime($unAvis['datepost']);
            $c->setDatePost($date);
            $avis[] = $c;
        }
        return $avis;
    }

    public static function getUnAvis($client, $apiAdress, $pathAvis)

    {
        dump($apiAdress.$pathAvis);
        $response = $client->request('GET', $apiAdress.$pathAvis, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $a = new Avis();
        $a->setId($content['id']);
        $a->setTitre($content['titre']);
        $a->setCommentaire($content['commentaire']);
        $date = new \DateTime($content['datepost']);
        $a->setDatePost($date);

        return $a;
    }


}
