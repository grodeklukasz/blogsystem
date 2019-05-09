<?php
namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;




class BlogController extends AbstractController{


    /**
     * @Route("/newblog", name="blog")
     */

     public function index(){

        $entityManager = $this->getDoctrine()->getManager();

        $blog = new Blog();
        $blog->setTitle('R6_Blog');
        $blog->setDescription('This is blog about R6');

        $entityManager->persist($blog);

        $entityManager->flush();

        return new Response('Saved new Blog with id:'.$blog->getId());


     }
    /**
     * Matches /blog exactly
     * @Route("/blog", name="blog_list")
     */


     public function list(){

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->findAll();

    
      
        return $this->render('blog/list.html.twig',[
            "blogs" => $blogs
        ]);

     }

     /**
      * Matches /blog/*
      * but not /blog/slug/extra-part
      * @Route("/blog/{slug}", name="blog_show")
      */

      public function show($slug){

        $blog = $this->getDoctrine()
        ->getRepository(Blog::class)
        ->find($slug);

        if(!$blog){
          throw $this->createNotFoundException(
            "No Blog found for id: ".$slug
          );
        }

    
        return $this->render('blog/show.html.twig',[
            'blog' => $blog
        ]);
      }

      /**
       * @Route("/red", name="redirect")
       */
      public function redirection(){
        
        
        return $this->redirectToRoute('blog_list');

      }
}

?>