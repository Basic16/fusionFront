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
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
class PaypalController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/paypal", name="paypal")
     */
    public function index(): Response
    {

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'PaypalController',
            'theme'=>$theme
        ]);
    }
    /**
     * @Route("/payment", name="payment")
     */
    public function paypal(){
        $plan = new Plan();
        $plan->setName('Abonnement professionnel')
            ->setDescription('Annuel')
            ->setType('FIXED');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Year')
            ->setFrequencyInterval('1')
            ->setCycles('1')
            ->setAmount(new Currency(array('value' => 250, 'currency' => 'EUR')));


        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 0, 'currency' => 'USD')));
        $paymentDefinition->setChargeModels(array($chargeModel));


        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl($this->generateUrl("success",[],UrlGeneratorInterface::ABSOLUTE_URL))
            ->setCancelUrl($this->generateUrl("error",[],UrlGeneratorInterface::ABSOLUTE_URL))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0')
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'EUR')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $plan->create($apiContext);

            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $apiContext);
                $plan = Plan::get($createdPlan->getId(), $apiContext);
                    require_once("test/create_argument.php");
                // Output plan id
                echo $plan->getId();
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }
}
