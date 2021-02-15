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
use App\Utilitaire\RestAvis;
use App\Utilitaire\RestTheme;
use App\Form\AjoutAvisType;

use App\Form\ModifThemeType;

class BlogController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/index2", name="index2")
     */
    public function index(): Response
    {
        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        return $this->render('blog/index.html.twig', [
            'articles'=>$articles,
            'categories'=>$categories,
            'theme'=>$theme
        ]);
    }
    /**
     * @Route("/article/{url}", name="article_show")
     */
    public function articleShow($url, Request $request): Response
    {


        $date = new \DateTime("now");

        $form = $this->createForm(AjoutAvisType::class);

        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));

        $article = RestArticle::getUnArticle($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $url);

        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $titre = $form->get("titre")->getData();
                $commentaire = $form->get("commentaire")->getData();
                $articleId = $article->getId();
                $response = $this->client->request('POST', 'http://s1.nuage-pedagogique.fr/cocorico-4181/API/public/api/avis', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['titre' => $titre, 'commentaire' =>$commentaire, 'datepost'=> $date->format("Y-m-d"), 'article'=>'/cocorico-4181/API/public/api/articles/'.$articleId],
                ]);
            }
        }

        dump($article);

        return $this->render('blog/article-show.html.twig', [

            'article'=>$article,
            'articles'=>$articles,
            'theme'=>$theme,
            'categories'=>$categories,
            'form'=>$form->createView()

        ]);

    }
    /**
     * @Route("/categorie/{libelle}", name="articles_par_categorie")
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





        /*$repoArticle = $this->getDoctrine()->getRepository(Article::class);
        $articlesParCategorie = $repoArticle->findBy(array('categorie'=>$categorie), array('date'=>'DESC'));
        $articles = $repoArticle->findBy(array(), array('date'=>'DESC'));
        $repoCategorie = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $repoCategorie->findBy(array(), array('libelle'=>'ASC'));*/
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
     * @Route("/rechercher", name="rechercher")
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
     * @Route("/modifTheme", name="modif_theme")
     */

    public function modifTheme(Request $request): Response
    {



        $theme = RestTheme::getTheme($this->client, $this->getParameter('apiAdress'));
        dump($theme);

        $form = $this->createForm(ModifThemeType::class, $theme);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $header = $form->get("header")->getData();
                $footer = $form->get("footer")->getData();
                $response = $this->client->request('PATCH', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/themes/1', [
                    'headers' => [
                        'Content-Type' => 'application/merge-patch+json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['header' => $header, 'footer'=>$footer],
                ]);

                $this->addFlash('notice', 'Catégorie modifiée');
            }
            return $this->redirectToRoute('index');
        }


        return $this->render('blog/modif_theme.html.twig', [
            'theme'=>$theme,
            'form'=>$form->createView(),


        ]);



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