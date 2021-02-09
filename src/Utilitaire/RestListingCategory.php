<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;
use App\Entity\ListingTranslation;
use App\Entity\ListingLocation;
use App\Entity\User;
use App\Entity\UserImage;

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

        //dump($content);

        $listingCategorie = new ListingCategory();
        $listingCategorie->setTexte($content[0]["texte"]);
        $listingCategorie->setTexteaccueil($content[0]["texteaccueil"]);
        $listingCategorie->setImage($content[0]["image"]);
        $listingCategorie->setImageaccueil($content[0]["imageaccueil"]);

        $listingCategorieTranslation = new ListingCategoryTranslation();
        $listingCategorieTranslation->setName($content[0]["listingCategoryTranslations"][0]["name"]);
        $listingCategorie->addListingCategoryTranslation($listingCategorieTranslation);

        foreach ($content[0]["listings"] as $l) {
            // Annonce
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            // Catégorie de l'annonce
            $listingCategory = new ListingCategory();
            $listing->addListingCategory($listingCategory);

            // Nom de catégorie de l'annonce
            $listingCategoryTranslation = new ListingCategoryTranslation();
            $listingCategoryTranslation->setName($content[0]["listingCategoryTranslations"][0]["name"]);
            $listingCategory->addListingCategoryTranslation($listingCategoryTranslation);

            // Titre de l'annonce
            $listingTranslation = new ListingTranslation();
            $listingTranslation->setTitle($l["translation"][0]["title"]);
            $listingTranslation->setSlug($l["translation"][0]["slug"]);
            $listing->addTranslation($listingTranslation);

            // Image de l'annonce
            $listingImage = new ListingImage();
            $listingImage->setName($l["ListingImage"][0]["name"]);
            $listing->addListingImage($listingImage);

            // Ville de l'annonce
            $ListingLocation = new ListingLocation();
            $ListingLocation->setCity($l["location"]["city"]);
            $listing->setLocation($ListingLocation);
        
            // Utilisateur de l'annonce
            $user = new User();
            $listing->setUser($user);
            
            // Image de l'utilisateur de l'annonce
            $userImage = new UserImage();
            // Si l'utilisateur à plus d'une image de profile
            if(count($l["user"]["images"]) > 0){
                $userImage->setName($l["user"]["images"][0]["name"]);
            }else{
                $userImage->setName("img2.png"); // Default image
            }
            $user->addImage($userImage);

            $listingCategorie->addListing($listing);
        }
 
        return $listingCategorie;
    }

}
