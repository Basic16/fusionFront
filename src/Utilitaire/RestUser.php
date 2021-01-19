<?php

namespace App\Utilitaire;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Entity\UserImage;

class RestUser
{

    public function __construct(){}

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
        $listWedders = [];

        foreach($content as $w){
            
            $wedder = new User();
            $wedder->setId($w["id"]);
            $wedder->setLastname($w['lastName']);
            $wedder->setFirstname($w['firstName']);
            $wedder->setEmail($w['email']);
            $wedder->setPhone($w['phone']);
            $wedder->setNationality($w['nationality']);
            $wedder->setCompanyName($w['companyName']);
            $wedder->setProfession($w['profession']);

            $wedderAddress = new UserAddress();
            $wedderAddress->setAddress($w["addresses"][0]["address"]);
            $wedderAddress->setCity($w["addresses"][0]["city"]);

            $wedderImage = new UserImage();
            $wedderImage->setName($w["images"][0]["name"]);

            $wedder->addAddress($wedderAddress);
            $wedder->addImage($wedderImage);

            $listWedders[] = $wedder;
            
        }

        return $listWedders;
    }

}
