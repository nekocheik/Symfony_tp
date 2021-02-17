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
  private $categories = ['Brune', 'Ambrée', 'Blanche', 'Sans alcool'];

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
    }


    /**
     * @Route("/menu", name="menu")
     */
    public function mainMenu(): Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      $categorys = $this->getDoctrine()->getRepository(Category::class);
      $repoCategorys = $categorys->findByTerm("normal");

      return $this->render('partial/main_menu.html.twig', [ 
        'categorys' => $repoCategorys,
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
      return $this->render('bar/index.html.twig', [
        'title' => 'bar',
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions()
    {

      return $this->render('mentions/index.html.twig', [
        'title' => 'Mentions légales',
        ]);
    }

    // ceci bloque une possible réponse au client 
    private function beers_api()
    {
      $response = $this->client->request(
        'GET',
        'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json'
        );

      $statusCode = $response->getStatusCode();
      // $statusCode = 200
      $contentType = $response->getHeaders()['content-type'][0];
      // $contentType = 'application/json'
      $content = $response->getContent();
      // $content = '{"id":521583, "name":"symfony-docs", ...}'
      $content = $response->toArray();
      // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

      return $content;
    }

    /**
     * @Route("/beers", name="beers")
     */
    public function beers()
    {
      $beerRepo = $this->getDoctrine()->getRepository(Beer::class);

      return $this->render('beers/index.html.twig', [
        'title' => 'Page bières',
        'beers' => $beerRepo->findAll()
        ]);
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
     * @Route("/", name="home")
     */
    public function home()
    {
      $beers = $this->getDoctrine()->getRepository(Beer::class);
      $last_beers = $beers->findLastBeers();

      return $this->render('home/index.html.twig', [
        'title' => "Page d'accueil",
        'beers' => $last_beers
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
        'title' => 'cheik',
        'beers' => $beers,
        ]);
    }


    /**
     * @Route("/newbeer", name="create_beer")
     */
    public function createBeer()
    {
      $entityManager = $this->getDoctrine()->getManager();

      $beer = new Beer();
      $beer->setname('Super Beer');
      $beer->setPublishedAt(new \DateTime());
      $beer->setDescription('Ergonomic and stylish!');

      // tell Doctrine you want to (eventually) save the Beer (no queries yet)
      $entityManager->persist($beer);

      // actually executes the queries (i.e. the INSERT query)
      $entityManager->flush();

      return new Response('Saved new beer with id ' . $beer->getId());
    
    /**
     * @Route("/newbeercat", name="newbeercat")
     */
    public function createBeerCat()
    {
      $this->generateCat();
      $entityManager = $this->getDoctrine()->getManager();
      $repository = $this->getDoctrine()->getRepository(Category::class);

      $beer = new Beer();
      $beer->setName('Bière Ardèchoise');
      $beer->setPublishedAt(new \DateTime());
      $beer->setDescription('Ergonomic and stylish!');

      foreach ($repository->findAll() as $category) {
        $beer->addCategory($category);
        }

        $entityManager->persist($beer);

        $entityManager->flush();

        return new Response('ok beer into categories');
    }
}
