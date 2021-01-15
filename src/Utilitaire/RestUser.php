<?php

namespace App\Utilitaire;

use App\Entity\User;
use PhpParser\Node\Expr\Cast\Array_;

class RestUser
{

    public function __construct(){

    }

    /**
     * Afficher tout les wedder du plus récent au plus vieux
     */
    public static function getLesWedders($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'users?personType=2', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $wedders = [];

        /*echo '<pre>';
        var_dump($content);
        echo '</pre>';*/

        foreach($content as $w){
            $unWeeder["id"] = $w['id'];
            $unWeeder["email"] = $w['email'];
            $unWeeder["enabled"] = $w['enabled'];
            $unWeeder["lastName"] = $w['lastName'];
            $unWeeder["firstName"] = $w['firstName'];
            $unWeeder["nationality"] = $w['nationality'];
            $unWeeder["companyName"] = $w['companyName'];
            $unWeeder["profession"] = $w['profession'];
            $unWeeder["country"] = "";

            $unWeeder["images"] = "";
            $unWeeder["phone"] = "";

            $wedders[] = $unWeeder;
        }

        return $wedders;
    }


    public static function getLastWedders($client, $apiAdress, $apiServer)
    {
       
    }
}
