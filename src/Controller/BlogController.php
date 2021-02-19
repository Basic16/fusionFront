<?php

namespace App\Controller;

use App\Utilitaire\RestTheme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use App\Repository\ImageRepository;
use App\Repository\CommentaireRepository;
use App\Entity\Commentaire;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Image;
use App\Form\CommentaireType;
use App\Form\SearchFormType;
use App\Form\AjoutArticleType;
use App\Form\ModifierArticleType;
use App\Form\AjoutCategorieType;
use App\Form\ModifierCategorieType;
use Doctrine\ORM\Mapping\Cache;
use PhpParser\Node\Scalar\StringTest;
use App\Form\AjoutImageType;

use App\Utilitaire\RestArticle;
use App\Utilitaire\RestCategorie;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BlogController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/listeArticles", name="listeArticles")
     */
    //Fini
    public function index(Request $request): Response{

        $categories = RestCategorie::getLesCategories($this->client, $this->getParameter('apiAdress'));
        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));
        dump($articles);

        return $this->render('backend/index.html.twig', [
            'articles' => $articles,
            'categories'=>$categories
        ]);
    }



//##############################################################################
 


    /**
     * @Route("/article/{url}", name="article_show")
     */
    public function articleShow($url, Request $request, CommentaireRepository $CommentaireRepository): Response
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
           
            $commentaires = $CommentaireRepository->commentaireArticle($url);
        return $this->render('backend/article-show.html.twig', [

            'article'=>$article,
            'articles'=>$articles,
            'categories'=>$categories,
            'theme'=>$theme,
            'form'=>$form->createView(),
      
            'commentaires' => $commentaires

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
        $articles = RestArticle::getLesArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        return $this->render('backend/articles-par-categorie.html.twig', [
            'categorie'=>$categorie,
            'articles'=>$articles,
            'articlesParCategorie'=> $articlesParCategorie,
            'categories'=>$categories
        ]);
    }

    public function searchForm(Request $request){
        $form = $this->createForm(SearchFormType::class, null, array('action' => $this->generateUrl('rechercher')));
        return $this->render('backend/search-form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/rechercher", name="rechercher")
     */
    public function rechercher(Request $request){
        $form = $this->createForm(SearchFormType::class, null, array('action' => $this->generateUrl('rechercher')));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $repoArticle = $this->getDoctrine()->getRepository(Article::class);
                $recherches = $repoArticle->rechercher($form->get('rechercher')->getData());
                $articles = $repoArticle->findBy(array(), array('date' => 'DESC'));
                $repoCategorie = $this->getDoctrine()->getRepository(Categorie::class);
                $categories = $repoCategorie->findBy(array(), array('libelle' => 'ASC'));
            }
            return $this->render('backend/rechercher.html.twig', ['articles' => $articles, 'recherches' => $recherches, 'recherche' => $form->get('rechercher')->getData(), 'categories' => $categories]);
        }
        return $this->redirectToRoute('index');
    }

    ////////////////////////////////Ajouter un Article/////////////////////////////////////////

    /**
     * @Route("/ajoutArticle", name="ajoutArticle")
     */
    public function ajoutArticle(Request $request)
    {

        $date = new \DateTime("now");
        $response = $this->client->request('GET', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $categories = $response->toArray();
        dump($categories);

        $c = array();
        foreach($categories as $uneCategorie){
            $c[$uneCategorie['libelle']] = $uneCategorie['id'];
        }
        dump($c);
        $form = $this->createForm(AjoutArticleType::class,null,array("categories"=>$c));

        $em = $this->getDoctrine();

        $repoImage = $em->getRepository(Image::class);
        $article = new Article();

        $form = $this->createForm(AjoutArticleType::class,null,array("categories"=>$c));




        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $titre = $form->get("titre")->getData();
                $contenu = $form->get("contenu")->getData();
                $url = $form->get("url")->getData();
                $extrait = substr(strip_tags($contenu), 0, 100) . "...";
                $nomImage = $form->get("image")->getData();
                if($this->between('file/', '?', $nomImage) == ""){
                    $urlImage = null;
                }
                else{$urlImage = "../uploads/images/" . $this->between('file/', '?', $nomImage);}
                $uri = '/'.$this->getParameter('apiUrl').'categories/'.$form->get("categories")->getData();
                $categories = $form->get("categories")->getData();
                $response = $this->client->request('POST', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/articles', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['titre' => $titre, 'contenu' =>$contenu, 'date'=> $date->format("Y-m-d"), 'url' => $url, 'extrait'=> $extrait, 'image'=>$nomImage, 'categorie'=>$uri],
                ]);


            }
            return $this->redirectToRoute('listeArticles');

        }

        return $this->render('backend/ajout-article.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    public function between($p1, $p2, $p3)
    {
        return $this->before($p2, $this->after($p1, $p3));
    }
    public function after($p1, $p2)
    {
        if (!is_bool(strpos($p2, $p1)))
            return substr($p2, strpos($p2, $p1) + strlen($p1));
    }
    public function before($p1, $p2)
    {
        return substr($p2, 0, strpos($p2, $p1));
    }



    /**
     * @Route("/apercu", name="apercu")
     */
    public function apercuShow(Request $request){
        $titre = $request->get('modifier_article')['titre'];
        $contenu = $request->get('modifier_article')['contenu'];

        $ajouttitre = $request->get('ajout_article')['titre'];
        $ajoutcontenu =  $request->get('ajout_article')['contenu'];

        $date = new \DateTime();

        return $this->render('backend/apercu.html.twig', [

            'titreAjout' => $ajouttitre,
            'contenuAjout' => $ajoutcontenu,
            'titre' => $titre,
            'contenu' => $contenu,
            'date' => $date
        ]);
    }


    ////////////////////////////////Modifier un Article/////////////////////////////////////////


    /**
     * @Route("/modifierArticle/{id}", name="modifierArticle",  requirements={"id"="\d+"})
     */

    public function modifierArticle(int $id,  Request $request)
    {
        $date = new \DateTime("now");
        $response = $this->client->request('GET', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $categories = $response->toArray();
        dump($categories);

        $c = array();
        foreach($categories as $uneCategorie){
            $c[$uneCategorie['libelle']] = $uneCategorie['id'];
        }
        dump($c);
        $form = $this->createForm(ModifierArticleType::class,null,array("categories"=>$c));

        $em = $this->getDoctrine();

        $repoImage = $em->getRepository(Image::class);
        $article = RestArticle::getLarticleId($this->client, $this->getParameter('apiAdress'),$this->getParameter('apiServer'), $id);
        dump($article);

        $form = $this->createForm(ModifierArticleType::class,null,array("categories"=>$c));


        $form = $this->createForm(ModifierArticleType::class, $article, array("categories"=>$c));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $titre = $form->get("titre")->getData();
                $contenu = $form->get("contenu")->getData();
                $url = $form->get("url")->getData();
                $extrait = substr(strip_tags($contenu), 0, 100) . "...";
                $nomImage = $form->get("image")->getData();
                if($this->between('file/', '?', $nomImage) == ""){
                    $urlImage = null;
                }
                else{$urlImage = "../uploads/images/" . $this->between('file/', '?', $nomImage);}
                $uri = '/'.$this->getParameter('apiUrl').'categories/'.$form->get("categories")->getData();
                $categories = $form->get("categories")->getData();
                $response = $this->client->request('PATCH', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/articles/'.$id, [
                    'headers' => [
                        'Content-Type' => 'application/merge-patch+json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['titre' => $titre, 'contenu' =>$contenu, 'date'=> $date->format("Y-m-d"), 'url' => $url, 'extrait'=> $extrait, 'image'=>$nomImage, 'categorie'=>$uri],
                ]);


            }
            return $this->redirectToRoute('index');
        }
        return $this->render('backend/modifier-article.html.twig', [
            'form' => $form->createView()
        ]);
    }


    ////////////////////////////////Modifier une categorie/////////////////////////////////////////


    /**
     * @Route("/modifierCategorie/{id}", name="modifierCategorie", requirements={"id"="\d+"})
     */
    public function modifierCategorie(int $id, Request $request)
    {
        $categorie = RestCategorie::getUneCategorieParId($this->client, $this->getParameter('apiAdress'), $id);
        dump($categorie);

        $form = $this->createForm(ModifierCategorieType::class, $categorie);


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $libelle = $form->get("libelle")->getData();
                $response = $this->client->request('PATCH', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/categories/'.$id, [
                    'headers' => [
                        'Content-Type' => 'application/merge-patch+json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['libelle' => $libelle],
                ]);
            }
            return $this->redirectToRoute('listeCategorie');
        }


        return $this->render('backend/modifier-categorie.html.twig', [
            'form' => $form->createView(),
            'categories' => $categorie

        ]);
    }


    ////////////////////////////////Liste de categorie/////////////////////////////////////////



    /**
     * @Route("/listeCategorie", name="listeCategorie")
     */
    //Manque Ajout Categorie
    public function listeCategorie(CategorieRepository $categorieRepository, Request $request){
        $categorie = new Categorie();
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);
        $form = $this->createForm(AjoutCategorieType::class, $categorie);


        $categories = RestCategorie::getCatNbArticles($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));
        dump($categories);


        return $this->render('backend/liste-categorie.html.twig', [
            'categories' => $categories, // Nous passons la liste des catégories à la vue
            'form' => $form->createView(),
            "artParCateg" => []/*$categorieRepository->nombreArticleParCategorie()*/


        ]);
    }

    /**
     * @Route("/ajoutCategorie", name="ajoutCategorie")
     */
    public function ajoutCategorie(Request $request)
    {
        $response = $this->client->request('GET', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $categories = $response->toArray();
        dump($categories);

        $form = $this->createForm(AjoutCategorieType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $libelle = $form->get("libelle")->getData();
                dump($libelle);

                $response = $this->client->request('POST', 'http://serveur1.arras-sio.com/symfony4-4149/API/public/api/categories', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => ['libelle' => $libelle],
                ]);
            }
            return $this->redirectToRoute('listeCategorie');

        }
        return $this->render('backend/ajout-categorie.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/galerie", name="galerie")
     */
        public function galerie(Request $request, ImageRepository $ImageRepository)
    {

        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }
        $em = $this->getDoctrine();
        $image = new Image();
        $repoImage = $em->getRepository(Image::class);
        $formImage = $this->createForm(AjoutImageType::class, $image);

        if ($request->get('suppimgs')!= null){
            foreach($request->get('suppimgs') as $idimage){
                $img = $repoImage->find($idimage);
                if ($img != null){
                    unlink ("../uploads/images/".$img->getNom());
                    $em->getManager()->remove($img);
                    $em->getManager()->flush();

                }
            }
            $this->addFlash('notice', 'image supprimée');
        }

        if (!empty($_FILES)) {
            $target_dir = '../uploads/images/';
            $target_file = md5(uniqid());
            $infoFichier = pathinfo($_FILES["file"]["name"]);
            $extension = $infoFichier['extension'];

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $target_file . "." . $extension)) {
                $status = 1;


                $image->setNom($target_file . "." . $extension); // Le nom du fichier va être celui généré
                $em = $em->getManager();
                $em->persist($image); // Enregistrement du fichier dans la table
                $em->flush();
            }
        }

        if ($request->get('supp') != null) {

            $imagesup = $repoImage->find($request->get('supp'));
            if ($imagesup != null) {
                $image = $this->getDoctrine()
                    ->getRepository(Image::class)
                    ->find($request->get('supp'));
                $nom = $image->getNom();
                unlink ("../uploads/images/".$nom);
                $em->getManager()->remove($imagesup);
                $em->getManager()->flush();
                $this->addFlash('notice', 'image supprimée');
            }
            return $this->redirectToRoute('galerie');
        }


        $compte = $ImageRepository->nombreImage();
        foreach ($compte as $resultat){
            $nombreImage = $resultat["nombre"];
        }
        
        $parPage = 9;

        
        $pages = ceil($nombreImage / $parPage);
        $pages = $pages;

        $premier = ($currentPage * $parPage) - $parPage;

        $imagePages = $ImageRepository->pagination($premier, $parPage);
        $images = $repoImage->findBy(array());
        if($currentPage < 2){
            $precedente = 1;
        }
        else{$precedente = $currentPage -1;}
        if($currentPage < $pages){
        $suivante = $currentPage +1;}
        else{$suivante = $currentPage ;}

        return $this->render('backend/galerie.html.twig', [
            'formImage' => $formImage->createView(),
            'imagePages'=>$imagePages,
            'pages'=>$pages,
            'pageActuelle'=>$currentPage,
            'precedente'=>$precedente,
            'suivante'=>$suivante,
            'nombreimage'=>$nombreImage
        ]);
    }

    /**
     * @Route("/delete_cat/{id}", name="delete_cat")
     */

    public function deleteCat($id): Response
    {
        $verifArticle = RestCategorie::getVerifArticle($this->client, $this->getParameter('apiAdress'), $id);
        dump($verifArticle);
        if ($verifArticle == false) {
            RestCategorie::deleteCat($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $id);
            $this->addFlash('notice', 'Categorie supprimée');
        }
        else{
            $this->addFlash('notice', 'Categorie ne peut pas être supprimée, il y reste des articles');
        }
        return $this->redirectToRoute('listeCategorie');

    }

 /**
     * @Route("/delete_article/{id}", name="delete_article")
     */

    public function deleteArticle($id): Response
    {
        RestArticle::deleteArticle($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $id);
        return $this->redirectToRoute('index');

    }


}