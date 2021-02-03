<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;
use App\Entity\User;
use App\Entity\UserAddress;
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
            
            $listing = new Listing();
            $listing->setPrice($l["price"]);

            $listingCategory = new ListingCategory();
            $listingCategory->setUrl($l["ListingCategory"][0]["url"]);
            $listing->addListingCategory($listingCategory);

            $listingCategoryTranslation = new ListingCategoryTranslation();
            $listingCategoryTranslation->setName($l["ListingCategory"][0]["listingCategoryTranslations"][0]["name"]);
            $listingCategoryTranslation->setLocale("FR");
            $listingCategory->addListingCategoryTranslation($listingCategoryTranslation);

            $listingImage = new ListingImage();
            $listingImage->setName($l["ListingImage"][0]["name"]);
            $listing->addListingImage($listingImage);
        
            $user = new User();
            $user->setProfession($l["user"]["profession"]);
            $user->setCompanyName($l["user"]["companyName"]);
            $listing->setUser($user);
            
            // Si l'utilisateur à plus d'une image de profile
            $userImage = new UserImage();
            if(count($l["user"]["images"]) > 0){
                $userImage->setName($l["user"]["images"][0]["name"]);
            }else{
                $userImage->setName("img2.png"); // Default image
            }
            $user->addImage($userImage);

            $userAdress = new UserAddress();
            $userAdress->setCity($l["user"]["addresses"][0]["city"]);
            $user->addAddress($userAdress);

            $listListing[] = $listing;
    
        }

        return $listListing;
    }

    
    /**
     * Affiche les listing selon leur nom et leur profession
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

        //dump($content);

        $listingList = [];
        foreach($content as $l){
            
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            $listingImage = new ListingImage();
            $listingImage->setName($l["listing_image"]);
            $listing->addListingImage($listingImage);
            
            $listingCategory = new ListingCategory();
            $listing->addListingCategory($listingCategory);

            $listingCategoryTranslation = new ListingCategoryTranslation();
            $listingCategoryTranslation->setName($l["category"]);
            $listingCategory->addListingCategoryTranslation($listingCategoryTranslation);

            $user = new User();
            $user->setCompanyName($l["company_name"]);
            $user->setProfession($l["profession"]);
            $listing->setUser($user);
            
            $userAdress = new UserAddress();
            $userAdress->setCity($l["city"]);
            $user->addAddress($userAdress);

            $userImage = new UserImage();
            if($l["user_image"] != null){
                $userImage->setName($l["user_image"]);
            }else{
                $userImage->setName("img2.png"); // Default image
            }
            $user->addImage($userImage);
            
            $listingList[] = $listing;

        }

        return $listingList;
    }

}
