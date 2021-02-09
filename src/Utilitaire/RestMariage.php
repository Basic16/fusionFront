<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Entity\ListingCategory;
use App\Entity\ListingCategoryTranslation;
use App\Entity\ListingLocation;
use App\Entity\ListingTranslation;
use App\Entity\Mariage;
use App\Entity\User;
use App\Entity\UserAddress;
use App\Entity\UserImage;

class RestMariage
{

    public function __construct(){}

    /**
     * Récupère tout les type de mariage
     */
    public static function getLesMariages($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'mariages', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $mariages = array();
        //dump($content);
        foreach ($content as $unMariage) {
            $a = new Mariage();
            $a->setNom($unMariage['nom']);
            $a->setTexte($unMariage['texte']);
            $a->setImage($unMariage['image']);
            $a->setUrl($unMariage['url']);
            if(isset($unMariage["traduction"])){
                $a->setTraduction($unMariage['traduction']);
            }
            $a->setImageaccueil($unMariage['imageaccueil']);
            if (isset($unMariage['images'])) {
                $a->setImage($unMariage['images']);
            }
            if(isset($unMariage["logo"])){
                $a->setLogo($unMariage["logo"]);
            }
            $mariages[] = $a;
        }
        return $mariages;
    }

    /*
        Récupère les information ainsi que les listing d'un mariage en particulier
     */
    public static function getUnMariage($client, $apiAdress, $apiServer, $urlMariage)
    {
        $response = $client->request('GET', $apiAdress . 'mariages?url=' . $urlMariage . '&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        //dump($content);

        $mariage = new Mariage();
        $mariage->setNom($content[0]['nom']);
        $mariage->setTexte($content[0]['texte']);
        $mariage->setImage($content[0]['image']);
        $mariage->setUrl($content[0]['url']);
        if(isset($content[0]['traduction'])){
            $mariage->setTraduction($content[0]['traduction']);
        }
        $mariage->setImageaccueil($content[0]['imageaccueil']);

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
            if(count($l["user"]["images"]) > 0){
                $userImage->setName($l["user"]["images"][0]["name"]);
            }else{
                $userImage->setName("img2.png"); // Default image
            }
            $user->addImage($userImage);

            $mariage->addListing($listing);
        }

        return $mariage;
    }
}
