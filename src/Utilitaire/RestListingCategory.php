<?php

namespace App\Utilitaire;

use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;

class RestListingCategory
{

    public function __construct(){}

    public static function getLesListinCategory($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'listing_categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listingsCategory = array();
        foreach ($content as $uneCategorie) {
            if(array_key_exists ( 'imageaccueil' , $uneCategorie )){
                $a = new ListingCategory();
                $a->setId($uneCategorie['id']);
                //$a->setUrl();
                //$a->setTexte();
                //$a->setTexteaccueil($uneCategorie['id']);
                //$a->setImage();
                $a->setImageaccueil($uneCategorie['imageaccueil']);
                //$a->setTitle();
                //$a->setDescription();
                //$a->setAccueil();
                //$a->setLft();
                //$a->setLvl();
                //$a->setRgt();
                //$a->setListingCategoryTranslations();

                $listingsCategoryTranslation = new ListingCategoryTranslation();
                $listingsCategoryTranslation->setName($uneCategorie['listingCategoryTranslations'][0]['name']);
                //$listingsCategoryTranslation->setSlug($uneCategorie['listingCategoryTranslations'][0]['slug']);
    
                //$a->add($listingsCategoryTranslation);

                $listingsCategory[] = $a;

            }
           
        }
        return $listingsCategory;
    }
}
