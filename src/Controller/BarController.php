<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Entity\Beer;
use App\Entity\Category;

class BarController extends AbstractController
{

  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
      $beers = $this->getDoctrine()->getRepository(Beer::class);
      $last_beers = $beers->findLastBeers();

      return $this->render('home/index.html.twig', [
        'title' => "Page d'accueil",
        'beers' => $last_beers,
        ]);
    }


    /**
     * @Route("/menu", name="menu")
     */
    public function mainMenu( $route_name, $category_id ): Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      $categorys = $this->getDoctrine()->getRepository(Category::class);
      $repoCategorys = $categorys->findByTerm("normal");

      return $this->render('partial/main_menu.html.twig', [ 
        'categorys' => $repoCategorys,
        'route_name' => $route_name,
        'category_id' => $category_id,
      ]);
    }


    /**
     * @Route("/card-beer", name="bar")
     */
    public function card_beer ( $beer ): Response
    {
      return $this->render('partial/card-beer.html.twig', [ 'beer' => $beer ]);
    }

    /**
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
      return $this->render('bar/index.html.twig', [ 'title' => 'bar', ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions()
    {
      return $this->render('mentions/index.html.twig', ['title' => 'Mentions légales']);
    }

    /**
     * @Route("/beers", name="beers")
     */
    public function beers()
    {
      $beerRepo = $this->getDoctrine()->getRepository(Beer::class);
      return $this->render('beers/index.html.twig', [ 'title' => 'Page bières', 'beers' => $beerRepo->findAll() ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     */
    public function show($id)
    {
      $beerRepo = $this->getDoctrine()->getRepository(Beer::class);
      $beer = $beerRepo->find($id);
      if (!$beer) { return $this->redirectToRoute('home'); }
      return $this->render('beers/sigleBeer.html.twig', [
        'title' => 'Fiche produit',
        'beer' => $beer,
      ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function category($id)
    {
      $catRepo = $this->getDoctrine()->getRepository(Category::class);
      $category = $catRepo->find($id);
      $beers = $category->getBeers()->getValues();
      return $this->render('category/index.html.twig', [
        'title' => $category->getName(),
        'beers' => $beers,
        ]);
    }
}
