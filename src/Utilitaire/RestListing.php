<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
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
            //$listing->setUpdatedat($l["updatedat"]);

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
                $userImage->setName("default-user.png"); // Default image
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
    public static function getLesListingRecherche($client, $apiAdress, $apiServer, $recherche)
    {
        $response = $client->request('GET', $apiAdress . 'users?companyName='.$recherche.'&profession='."".'&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        //dump($content);

        $listingList = [];
        foreach($content as $u){
            
            $user = new User();
            $user->setCompanyName($u["companyName"]);
            $user->setProfession($u["profession"]);
            
            $userAdress = new UserAddress();
            $userAdress->setCity($u["addresses"][0]["city"]);
            $user->addAddress($userAdress);

            $userImage = new UserImage();
            if(count($u["images"]) > 0){
                $userImage->setName($u["images"][0]["name"]);
            }else{
                $userImage->setName("default-user.png"); // Default image
            }
            $user->addImage($userImage);
            
            foreach ($u["Listing"] as $l) {
                $listing = new Listing();
                $listing->setPrice($l["price"]);
                $listing->setCertified($l["certified"]);

                $listingImage = new ListingImage();
                $listingImage->setName($l["ListingImage"][0]["name"]);
                
                $listing->addListingImage($listingImage);
                $listing->setUser($user);

                $listingList[] = $listing;
            }

        }

        return $listingList;
    }

}
