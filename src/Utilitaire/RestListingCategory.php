<?php

namespace App\Utilitaire;

use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;

class RestListingCategory
{

    public function __construct()
    {
    }

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
                if (isset($uneCategorie['texte'])) {
                    $a->setTexte($uneCategorie['texte']);
                }
                if (isset($uneCategorie["imageaccueil"])) {
                    $a->setImageaccueil($uneCategorie['imageaccueil']);
                }
                if (isset($uneCategorie["imageaccueil"])) {
                    $a->setDescription($uneCategorie['description']);
                }
                //$a->setListingCategoryTranslations();

                $translation = new ListingCategoryTranslation();
                $translation->setName($uneCategorie["listingCategoryTranslations"][0]["name"]);
                $translation->setSlug($uneCategorie["listingCategoryTranslations"][0]["slug"]);

                $a->addListingCategorieTranslation($translation);

                $listingsCategory[] = $a;
            }
            
        }

        return $listingsCategory;
    }
}
