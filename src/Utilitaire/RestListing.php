<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;
use App\Entity\ListingLocation;
use App\Entity\ListingTranslation;
use App\Entity\User;
use App\Entity\UserImage;

class RestListing
{

    public function __construct(){}

    /**
     * Afficher tout les listing du plus récent au plus vieux
     */
    public static function getLesListing($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'listings?page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listListing = [];
        //dump($content);

        foreach($content as $l){
            // Annonce
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            // Catégorie de l'annonce
            $listingCategory = new ListingCategory();
            $listingCategory->setUrl($l["ListingCategory"][0]["url"]);
            $listing->addListingCategory($listingCategory);

            // Nom de catégorie de l'annonce
            $listingCategoryTranslation = new ListingCategoryTranslation();
            $listingCategoryTranslation->setName($l["ListingCategory"][0]["listingCategoryTranslations"][0]["name"]);
            $listingCategoryTranslation->setLocale("FR");
            $listingCategory->addListingCategoryTranslation($listingCategoryTranslation);

            // Titre de l'annonce
            $listingTranslation = new listingTranslation();
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

            $listListing[] = $listing;
        }

        return $listListing;
    }

    
    /**
     * Affiche les listing selon la recherche du site (nom, profession ...)
     */
    public static function getLesListingRecherche($client, $apiAdress, $apiServer, $recherche, $lieu)
    {
        $url = 'custom/getListingRecherche?search='.$recherche.'&location='.$lieu;
        $response = $client->request('GET', $apiAdress . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        dump($content);

        $listingList = [];
        foreach($content as $l){
            // Annonce
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            // Catégorie de l'annonce
            $listingCategory = new ListingCategory();
            $listing->addListingCategory($listingCategory);

            // Nom de catégorie de l'annonce
            $listingCategoryTranslation = new ListingCategoryTranslation();
            $listingCategoryTranslation->setName($l["category"]);
            $listingCategory->addListingCategoryTranslation($listingCategoryTranslation);

            // Titre de l'annonce
            $listingTranslation = new listingTranslation();
            $listingTranslation->setTitle($l["title"]);
            $listingTranslation->setSlug($l["slug"]);
            $listing->addTranslation($listingTranslation);

            // Image de l'annonce
            $listingImage = new ListingImage();
            $listingImage->setName($l["listing_image"]);
            $listing->addListingImage($listingImage);

            // Ville de l'annonce
            $ListingLocation = new ListingLocation();
            $ListingLocation->setCity($l["city"]);
            $listing->setLocation($ListingLocation);
        
            // Utilisateur de l'annonce
            $user = new User();
            $listing->setUser($user);
            
            // Image de l'utilisateur de l'annonce
            $userImage = new UserImage();
            // Si l'utilisateur à plus d'une image de profile
            if(!empty($l["listing_image"])){
                $userImage->setName($l["listing_image"]);
            }else{
                $userImage->setName("img2.png"); // Default image
            }
            $user->addImage($userImage);

            $listingList[] = $listing;
        }

        return $listingList;
    }

    /**
      * Récupère toutes les données d'une annonce en particulier
      */
    public function getListing($client, $apiAdress, $apiServer, $url)
    {
        
    }

}
