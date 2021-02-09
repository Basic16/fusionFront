<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\ConnexionType;
use PhpParser\Node\Expr\BinaryOp\Equal;

class LoginController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function ConnexionController(Request $request): Response
    {

        if ($request->isMethod('POST')) {   
            $this->addFlash('notice', 'L\'espace membre n\'est  pas encore opérationelle');
            return $this->redirectToRoute('connexion');
        }

        $form = $this->createForm(ConnexionType::class);

        return $this->render('login/Connexion.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    /**
     * @Route("/inscrire", name="inscrire")
     */
    public function inscrire(Request $request/*,  UserPasswordEncoderInterface $passwordEncoder*/)
    {
        $user = new User();
        $form_registration = $this->createForm(InscriptionType::class, $user);   
        
        return $this->render('login/Common/_new_login_register.html.twig', [
            'form_registration'=>$form_registration->createView()
         ]);

        /*return $this->render('login/Inscription.html.twig', [
           'form'=>$form->createView()
        ]);*/
    }

}