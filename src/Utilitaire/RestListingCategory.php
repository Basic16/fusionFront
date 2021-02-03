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

    public function __construct(){}

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
        //dump($content);
        $listingsCategoryList = array();
        
        foreach ($content as $c) {

            if(array_key_exists ('imageaccueil', $c)){ 
                $listingsCategory = new ListingCategory();
                $listingsCategory->setUrl($c["url"]);
                $listingsCategory->setTexte($c["texte"]);
                $listingsCategory->setTexteaccueil($c["texteaccueil"]);
                $listingsCategory->setImage($c["image"]);
                $listingsCategory->setImageaccueil($c["imageaccueil"]);

                $lct = new ListingCategoryTranslation();
                $lct->setName($c["listingCategoryTranslations"][0]["name"]);
                $listingsCategory->addListingCategoryTranslation($lct);

                $listingsCategoryList[] = $listingsCategory;
            }

        }

        return $listingsCategoryList;
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
        //dump($content);

        $listListingsCategory = array();
        foreach ($content as $c) {

            $listingsCategory = new ListingCategory();
            $listingsCategory->setUrl($c["url"]);

            $listingsCategoryTranslation = new ListingCategoryTranslation();
            $listingsCategoryTranslation->setName($c["listingCategoryTranslations"][0]["name"]);
            $listingsCategory->addListingCategoryTranslation($listingsCategoryTranslation);

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
         $response = $client->request('GET', $apiAdress . 'listing_categories?page=1&url='.$url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        dump($content);

        $listingCategorie = new ListingCategory();
        $listingCategorie->setTexte($content[0]["texte"]);
        $listingCategorie->setTexteaccueil($content[0]["texteaccueil"]);
        $listingCategorie->setImage($content[0]["image"]);
        $listingCategorie->setImageaccueil($content[0]["imageaccueil"]);

        $listingCategorieTranslation = new ListingCategoryTranslation();
        $listingCategorieTranslation->setName($content[0]["listingCategoryTranslations"][0]["name"]);
        $listingCategorie->addListingCategoryTranslation($listingCategorieTranslation);

        foreach ($content[0]["listings"] as $l) {
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            $listingImage = new ListingImage();
            $listingImage->setName($l["ListingImage"][0]["name"]);
            $listing->addListingImage($listingImage);
                
            $user = new User();
            $user->setCompanyName($l["user"]["companyName"]);
            $user->setProfession($l["user"]["profession"]);
            $listing->setUser($user);

            $userImage = new UserImage();
            if($l["user"]["images"][0]["name"] != null){
                $userImage->setName($l["user"]["images"][0]["name"]);
            }else{ 
                $userImage->setName("img2.png");
            }
            $user->addImage($userImage);

            $userAddress = new UserAddress();
            $userAddress->setCity($l["user"]["addresses"][0]["city"]);
            $user->addAddress($userAddress);

            $listingCategorie->addListing($listing);
        }
 
        return $listingCategorie;
    }

}
