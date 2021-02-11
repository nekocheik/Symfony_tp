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
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        return $this->render('bar/index.html.twig', [
            'title' => 'The bar',
            'info' => 'Hello World'
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

        return $this->render('beers/index.html.twig', [
            'title' => 'Page beers',
            'beers' => $this->beers_api()['beers']
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {

        return $this->render('home/index.html.twig', [
            'title' => "Page d'accueil",
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

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($beer);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new beer with id ' . $beer->getId());
    }

    /**
     * @Route("/newcategory", name="newcategory")
     */
    public function createCategory()
    {

        // new category
        $category = new Category();
        $category->setName('Houblon');
        $category->setDescription('Houblon');

        // new beer
        $beer = new Beer();
        $beer->setName('Beer new');
        $beer->setPrice(19.99);
        $beer->setDescription('Ergonomic and stylish!');

        // relates this beer to the category
        $category->addBeer($beer);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->persist($beer);
        $entityManager->flush();

        return new Response(
            'Saved new beer with id: ' . $beer->getId()
                . ' and new category with id: ' . $category->getId()
        );
    }

    /**
     * @Route("/relation", name="relation")
     */
    public function showCategory()
    {
        $beers = $this->getDoctrine()->getRepository(Beer::class);
        $entityManager = $this->getDoctrine()->getManager();


        // new category Blonde
        $category = new Category();
        $category->setName('Blonde');
        $category->setDescription('Blonde');

        foreach ($beers->findAll() as $beer) {
            // relates this beer to the category
            $category->addBeer($beer);
        }

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response(
            'beers'
        );
    }
}
