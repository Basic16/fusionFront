<?php

namespace App\Utilitaire;

use App\Entity\Listing;
use App\Entity\ListingImage;
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
            $a->setTraduction($unMariage['traduction']);
            $a->setImageaccueil($unMariage['imageaccueil']);
            if (isset($unMariage['images'])) {
                $a->setImage($unMariage['images']);
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
        $mariage->setTraduction($content[0]['traduction']);
        $mariage->setImageaccueil($content[0]['imageaccueil']);

        $listListing = [];
        foreach ($content[0]["listings"] as $l) {
            $listing = new Listing();
            $listing->setPrice($l["price"]);
            $listing->setCertified($l["certified"]);

            // Si il y a au moins une image pour ce listing
            if(count($l["ListingImage"]) > 0){
                $listingImage = new ListingImage();
                $listingImage->setName($l["ListingImage"][0]["name"]);
                $listing->addListingImage($listingImage);
            }

            $user = new User();
            $user->setCompanyName($l["user"]["companyName"]);
            $user->setProfession($l["user"]["profession"]);
            $listing->setUser($user);

            $userAdress = new UserAddress();
            $userAdress->setCity($l["user"]["addresses"][0]["city"]);
            $user->addAddress($userAdress);

            $userImage = new UserImage();
            if(count($l["user"]["images"]) > 0){
                $userImage->setName($l["user"]["images"][0]["name"]);
            }else{
                $userImage->setName("default-user.png"); // Default image
            }
            $user->addImage($userImage);

            $listListing[] = $listing;
        }

        // Ajoute tout les listing dans mariage
        foreach ($listListing as $l) {
            $mariage->addListing($l);
        }

        return $mariage;
    }
}
