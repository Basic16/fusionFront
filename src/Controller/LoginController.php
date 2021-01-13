<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Controller\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\ConnexionType;

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
        $form = $this->createForm(InscriptionType::class, $user);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $mdpConf = $form->get('confirmation')->getData();
                $mdp = $user->getPassword();
                if($mdp == $mdpConf){
                    $user->setRoles(array('ROLE_USER'));
                    //$user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('notice', 'Inscription réussie');
                    return $this->redirectToRoute('inscrire');
                }
                else{
                    $this->addFlash('notice', 'Erreur de mot de passe');
                    return $this->redirectToRoute('inscrire');
                }
            }
        }        

        return $this->render('login/Inscription.html.twig', [
           'form'=>$form->createView()
        ]);
    }

}