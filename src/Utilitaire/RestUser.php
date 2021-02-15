<?php

namespace App\Utilitaire;

use App\Entity\User;
//use App\Entity\UserAddress;
//use App\Entity\UserImage;

class RestUser
{

    public function __construct(){}

    /**
     * Afficher tout les wedder du plus récent au plus vieux
     */
    public static function getLesUsers($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'users', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listUsers = [];

        foreach($content as $w){
            
            $user = new User();
            $user->setId($w["id"]);
            $user->setLastname($w['lastName']);
            $user->setFirstname($w['firstName']);
            $user->setEmail($w['email']);
            $user->setPersontype($w['personType']);

            $listUsers[] = $user;
            
        }

        return $listUsers;
    }

    public static function getLesWedders($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'users?personType=2', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listUsers = [];

        foreach($content as $w){
            
            $user = new User();
            $user->setId($w["id"]);
            $user->setLastname($w['lastName']);
            $user->setFirstname($w['firstName']);
            $user->setEmail($w['email']);
            $user->setPersontype($w['personType']);

            $listUsers[] = $user;
            
        }

        return $listUsers;
    }

    public static function getLesNonWedders($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'users?personType=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listUsers = [];

        foreach($content as $w){
            
            $user = new User();
            $user->setId($w["id"]);
            $user->setLastname($w['lastName']);
            $user->setFirstname($w['firstName']);
            $user->setEmail($w['email']);
            $user->setPersontype($w['personType']);

            $listUsers[] = $user;
            
        }

        return $listUsers;
    }

}
