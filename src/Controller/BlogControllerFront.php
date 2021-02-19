<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Commentaire;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\SearchFormType;
use App\Form\CommentaireType;
use App\Utilitaire\RestArticle;
use App\Utilitaire\RestCategorie;
use App\Utilitaire\RestAvis;
use App\Utilitaire\RestTheme;
use App\Form\AjoutAvisType;
use App\Repository\CommentaireRepository;

use App\Form\ModifThemeType;

class BlogControllerFront extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/index2", name="index2")
     */
    public function index(Request $request): Response
    {
        if ($request->get('page')!=null){
            $page = $request->get('page');
        }
        else{
            $page = 1;
        }

        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $page);

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        return $this->render('blog/index.html.twig', [
            'articles'=>$articles,
            'categories'=>$categories,
            'theme'=>$theme
        ]);
    }
    /**
     * @Route("/article_front/{url}", name="article_show_front")
     */
    public function articleShow($url, Request $request,  CommentaireRepository $CommentaireRepository)
    {


        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        $article = RestArticle::getUnArticle($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $url);

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));

        
        $em = $this->getDoctrine();
        $commentaire  = new Commentaire();
        $repoCommentaire = $em->getRepository(Commentaire::class);
        
        $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);
        
        if ($request->get('suppCom') != null) {

            $commentairesup = $repoCommentaire->find($request->get('suppCom'));;
            if ($commentairesup != null) {
                $commentaire = $this->getDoctrine()
                    ->getRepository(Commentaire::class)
                    ->find($request->get('suppCom'));

                $em->getManager()->remove($commentairesup);
                $em->getManager()->flush();
                $this->addFlash('notice', 'commentaire supprimé');
            }
            return $this->redirect($url);
        }



            if ($form->isSubmitted() && $form->isValid()) {
                $commentaireUti = $form->get('commentaire')->getData();
                $note = $form->get('note')->getData();
                $date= new \DateTime("now");
                $em = $this->getDoctrine()->getManager();
                $commentaire->setUtilisateur(1);
                $commentaire->setDate($date);
                $commentaire->setNote($note);
                $commentaire->setCommentaire($commentaireUti);
                $commentaire->setArticle($url);
                $em->persist($commentaire);
                $em->flush();
                $this->addFlash('notice', 'Commentaire posté');
                return $this->redirect($url);
            }


        dump($article);
        if ($article->getImage() != null) {
            $valeur = $article->getImage();
            $valeur = explode('src=', $valeur);
            $valeur = $valeur[1];
            $valeur = explode('"', $valeur);
            $valeur = $valeur[1];
        }
        else{
            $valeur = "https://cdn.pixabay.com/photo/2014/02/07/11/36/couple-260899_960_720.jpg";
        }
        
     

        $commentaires = $CommentaireRepository->commentaireArticle($url);
        return $this->render('blog/article-show.html.twig', [
            'form'=>$form->createView(),
            'commentaires'=>$commentaires,
            'article'=>$article,
            'articles'=>$articles,
            'theme'=>$theme,
            'categories'=>$categories,
            'image'=>$valeur,

        ]);

    }
    /**
     * @Route("/categorie_front/{libelle}", name="articles_par_categorie_front")
     *
     */
    public function articlesParCategorie($libelle): Response
    {

        $articlesParCategorie = RestCategorie::getArticlesByCat($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $libelle);

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        $categorie = RestCategorie::getCatLibelle($this->client, $this->getParameter('apiAdress'), $libelle);
        dump($categorie);

        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));


        return $this->render('blog/articles-par-categorie.html.twig', [
            'categorie'=>$categorie,
            'articles'=>$articles,
            'articlesParCategorie'=> $articlesParCategorie,
            'theme'=>$theme,

            'categories'=>$categories
        ]);
    }

    public function searchForm(Request $request){
        $form = $this->createForm(SearchFormType::class,null,array('action' => $this->generateUrl('rechercher')));
        return $this->render('blog/search-form.html.twig',['form'=>$form->createView()]);
    }



    /**
     * @Route("/rechercher_front", name="rechercher_front")
     */
    public function rechercher(Request $request){

        $test = $request->get('test');

        dump($test);

        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        $articleSearch = RestArticle::searchArticle($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $test);

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));


        dump($articleSearch);

        return $this->render('blog/rechercher.html.twig',['articleSearch'=>$articleSearch,
            'articles'=>$articles,
            'categories'=>$categories,
            'theme'=>$theme,

            'laRecherche'=>$test]);

    }

    /**
     * @Route("payement", name="payement")
     */

    public function Payement(Request $request): Response
    {
        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));


        return $this->render('blog/testabo.html.twig', [
            'theme'=>$theme,



        ]);
    }

}