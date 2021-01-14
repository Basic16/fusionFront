<?php

namespace App\Utilitaire;

use App\Entity\ListingCategory;


class RestCategorie
{

    public function __construct(){}

    public static function getLesListing($client, $apiAdress, $apiServer)
    {
        $response = $client->request('GET', $apiAdress . 'listing_categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $listings = array();
        foreach ($content as $unListing) {
            $a = new ListingCategory();
            $a->setId($unListing['id']);
            //$a->setLocationId($unListing['location_id']);
            //$a->setUserId($unListing['user_id']);
            $a->setStatus($unListing['status']);
            //$a->setType($unListing['type']);
            $a->setPrice($unListing['price']);
            $a->setCertified($unListing['certified']);
            //$a->setMaxDuration($unListing['max_duration']);
            //$a->setCancellationPolicy($unListing['cancellation_policy']);
            //$a->setAverageRating($unListing['average_rating']);
            //$a->setCommentCount($unListing['comment_count']);
            //$a->setAdminNotation($unListing['admin_notation']);
            //$a->setAvailabilitiesUpdatedAt($unListing['availabilities_updated_at']);
            //$a->setCreatedAt($unListing['createdAt']);
            //$a->setUpdatedAt($unListing['updatedAt']);
            $listings[] = $a;
        }
        return $listings;
    }

    /*public static function getUnMariage($client, $apiAdress, $apiServer, $idMariage)
    {
        $response = $client->request('GET', $apiAdress . 'mariages?id=' . $idMariage . '&page=1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        var_dump($content);
        $a = new Mariage();
            $a->setId($content[0]['id']);
            $a->setNom($content[0]['nom']);
            $a->setText($content[0]['texte']);
            $a->setImages($content[0]['image']);
            //$a->setUrl($unMariage['url']);
            $a->setTraduction($content[0]['traduction']);
            //$a->setLogo($unMariage['logo']);
            $a->setImageaccueil($content[0]['imageaccueil']);
            if (isset($content[0]['images'])) {
                $a->setImages($content[0]['images']);
            }
        return $a;
    }*/
}
