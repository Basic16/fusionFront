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

        foreach($content as $w){
            $unWeeder["id"] = $w['id'];
            $unWeeder["email"] = $w['email'];
            $unWeeder["enabled"] = $w['enabled'];
            $unWeeder["lastName"] = $w['lastName'];
            $unWeeder["firstName"] = $w['firstName'];
            $unWeeder["nationality"] = $w['nationality'];
            $unWeeder["companyName"] = $w['companyName'];
            $unWeeder["profession"] = $w['profession'];
            $unWeeder["url"] = "null";
            //$unWeeder["country"] = $unWeeder['country'];
            //$unWeeder["phone"] = $unWeeder['phone'];

            $responseImage = $client->request('GET', $apiAdress . 'user_images?page=1&user='.$w['id'], ['headers' => ['Accept' => 'application/json',],]);
            $image = $responseImage->toArray();


            if(count($image) > 0){
                $unWeeder["name"] = $image[0]["name"];
            }else{
                $unWeeder["name"] = null;
            }

            $wedders[] = $unWeeder;
        }

        return $wedders;
    }


    public static function getLastWedders($client, $apiAdress, $apiServer)
    {
       
    }
}
