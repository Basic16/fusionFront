<?php

namespace App\Utilitaire;

use App\Entity\UserAddress;
use PhpParser\Node\Expr\Cast\Array_;

class RestUserAddress
{

    public function __construct(){

    }


    public static function getWedderAddress($client, $apiAdress, $apiServer, $id)
    {
        $response = $client->request('GET', $apiAdress . 'user_addresses?id=&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        $wedderAddress = new UserAddress();
        $wedderAddress->setAddress($content["address"]);
        $wedderAddress->setCity($content["city"]);
        $wedderAddress->setZip($content["zip"]);
        $wedderAddress->setCountry($content["country"]);
        $wedderAddress->setCreatedat($content["createdat"]);
        $wedderAddress->setUpdatedat($content["updatedat"]);
        $wedderAddress->setUser($content["user"]);
        
        return $wedderAddress;
    }
}
