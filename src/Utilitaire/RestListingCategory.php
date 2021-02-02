<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;
use App\Entity\User;
use App\Entity\UserImage;
use App\Entity\UserAddress;

class RestListingCategory
{

    public function __construct()
    {
    }

    /**
     * Récupère la liste des catégorie de préstataire
     */
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
        //dump($content);
        foreach ($content as $uneCategorie) {
            if(array_key_exists ( 'imageaccueil' , $uneCategorie )){
                $a = new ListingCategory();
                $a->setId($uneCategorie['id']);
                if (isset($uneCategorie['texteaccueil'])) {
                    $a->setTexteaccueil($uneCategorie['texteaccueil']);
                }
                if (isset($uneCategorie["imageaccueil"])) {
                    $a->setImageaccueil($uneCategorie['imageaccueil']);
                }
                $a->setUrl($uneCategorie["url"]);

                $translation = new ListingCategoryTranslation();
                $translation->setName($uneCategorie["listingCategoryTranslations"][0]["name"]);
                $a->addListingCategorieTranslation($translation);

                $listingsCategory[] = $a;
            }
            
        }

        return $listingsCategory;
    }


    public static function getLesListinCategoryMariage($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'listing_categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        dump($content);

        $listListingsCategory = array();
        foreach ($content as $c) {

            $listingsCategory = new ListingCategory();
            $listingsCategory->setId($c["id"]);
            $listingsCategory->setUrl($c["url"]);

            $listingsCategoryTranslation = new ListingCategoryTranslation();
            $listingsCategoryTranslation->setName($c["listingCategoryTranslations"][0]["name"]);
            //$listingsCategoryTranslation->setSlug($c["listingCategoryTranslations"][0]["slug"]);

            $listingsCategory->addListingCategorieTranslation($listingsCategoryTranslation);
            $listListingsCategory[] = $listingsCategory;

        }

        return $listListingsCategory;
    }
    
    /*
        Récupère les information ainsi que les listing d'une catégorie en particulier
     */
     public static function getUnListingCategorie($client, $apiAdress, $apiServer, $url)
     {
         // Récupère les ListingsCatégories ainsi que leurs listings asscociés
         $response = $client->request('GET', $apiAdress . 'custom/getListingCategorie/'.$url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        //dump($content);
        $donnees = null;
        if(count($content["category"])>0){

            $listingCategorie = new ListingCategory();
            $listingCategorie->setTexte($content["category"][0]["texte"]);
            $listingCategorie->setTexteaccueil($content["category"][0]["texteaccueil"]);
            $listingCategorie->setDescription($content["category"][0]["description"]);
            $listingCategorie->setImage($content["category"][0]["image"]);

            $listingCategorieTranslation = new ListingCategoryTranslation();
            $listingCategorieTranslation->setName($content["category"][0]["name"]);
            $listingCategorie->addListingCategorieTranslation($listingCategorieTranslation);

            $listListing = [];
            foreach ($content["listings"] as $l) {
                $listing = new Listing();
                $listing->setPrice($l["price"]);
                $listing->setCertified($l["certified"]);

                $listingImage = new ListingImage();
                $listingImage->setName($l["image_listing"]);
                $listing->addListingImage($listingImage);
                
                $user = new User();
                $user->setCompanyName($l["company_name"]);
                $user->setProfession($l["profession"]);
                $listing->setUser($user);

                $userImage = new UserImage();
                if($l["image_user"] != null){
                    $userImage->setName($l["image_user"]);
                }else{ 
                    $userImage->setName("default-user.png");
                }
                $user->addImage($userImage);

                $userAddress = new UserAddress();
                $userAddress->setCity($l["city"]);
                $user->addAddress($userAddress);

                $listListing[] = $listing;
            }
 
            $donnees = [
                "category" => $listingCategorie,
                "listings" =>$listListing
            ];

        }

        return $donnees;
    }

    public function getNameCategoryByNameListing($client, $apiAdress, $apiServer, $idListing){
        // Récupère les ListingsCatégories ainsi que leurs listings asscociés
        $response = $client->request('GET', $apiAdress . 'custom/getListingCategorie/'.$url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        $donnees = null;

        return $donnees;
    }
}
