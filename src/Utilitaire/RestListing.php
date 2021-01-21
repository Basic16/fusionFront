<?php

namespace App\Utilitaire;

use App\Entity\Listing;

class RestListing
{

    public function __construct(){}

    public static function getLesListing($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'listings', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listings = array();
        foreach ($content as $unListing) {
        
            $listing = new Listing();
        
        }
        return $listings;
    }

}
