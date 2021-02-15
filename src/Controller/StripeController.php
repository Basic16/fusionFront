<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\SearchFormType;
use App\Utilitaire\RestArticle;
use App\Utilitaire\RestCategorie;
use App\Utilitaire\RestTheme;

use App\Form\ModifThemeType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/stripe", name="stripe")
     */
    public function index(): Response
    {
        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
            'theme'=>$theme
        ]);
    }
    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout(): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51IBz6yHvLG3kzNdDWqASjvIxaEnOHLntXhBDhc7fbxSgj0KvTaPerdFu5cYNQhS5QZ8OxfTSW6pNuD9RCpNz3zD800xzJyahus');
        $idcheckout = "{CHECKOUT_SESSION_ID}";

        $session = \Stripe\Checkout\Session::create([
            'success_url' => "http://serveur1.arras-sio.com/symfony4-4056/blog/public/success/{CHECKOUT_SESSION_ID}",
            'cancel_url' => $this->generateUrl("error",[],UrlGeneratorInterface::ABSOLUTE_URL),
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => "price_1IDlvvHvLG3kzNdD3vReLiXU",
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        return new JsonResponse([ 'id' => $session->id ]);

    }
    /**
     * @Route("/success/{idachat}", name="success")
     */
    public function success($idachat): Response
    {
        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        dump($idachat);
        return $this->render('stripe/success.html.twig', [
            'controller_name' => 'StripeController',
            'theme'=>$theme
        ]);

    }
    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        return $this->render('stripe/error.html.twig', [
            'controller_name' => 'StripeController',
            'theme'=>$theme
        ]);
    }
}