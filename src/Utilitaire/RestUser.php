<?php

namespace App\Utilitaire;

use App\Entity\User;
//use App\Entity\UserAddress;
//use App\Entity\UserImage;

class RestUser
{

    public function __construct(){}

    public static function getLesUsers($client, $apiAdress, $apiServer){
        $response = $client->request('GET', $apiAdress . 'custom/getLesUsers/', [
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
            $user->setPersontype($w['person_type']);
            
            //$user->setCreatedat($w['createdat']);

            $listUsers[] = $user;
            
        }

        return $listUsers;
    }

    public static function getLesWedders($client, $apiAdress, $apiServer){
        $response = $client->request('GET', $apiAdress . 'custom/getLesPrestataires/', [
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
            $user->setPersontype($w['person_type']);

            $listUsers[] = $user;
            
        }

        return $listUsers;
    }

    public static function getLastMonth($client, $apiAdress, $apiServer){
        $response = $client->request('GET', $apiAdress . 'custom/getLesUsersLastMonth/', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        return count($content);
    }

    public static function getLastWeek($client, $apiAdress, $apiServer){
        $response = $client->request('GET', $apiAdress . 'custom/getLesUsersLastWeek/', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        return count($content);
    }


}
