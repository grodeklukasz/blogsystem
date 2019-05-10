<?php
namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;




class BlogController extends AbstractController{


    /**
     * for example how save object to the database
     * @Route("/newblog", name="blog")
     */

     public function index(){

        $entityManager = $this->getDoctrine()->getManager();

        //$blog = new Blog();
        //$blog->setTitle('R6_Blog');
        //$blog->setDescription('This is blog about R6');

        //$entityManager->persist($blog);

        //$entityManager->flush();

        //return new Response('Saved new Blog with id:'.$blog->getId());

        return new Response('Saved new Blog with id:');
        


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
      * Matches /saveblog exactly
      * @Route("/saveblog", name="saveblog")
      */
      public function saveBlog(Request $request){

        $blog = new Blog();
        $blog->setTitle("my new Blog");
        $blog->setDescription("starts here ...");
        $blog->setCreatedAt(new \DateTime());

        $form = $this->createFormBuilder($blog)
            ->add('title',TextType::class)
            ->add('description', TextareaType::class)
            ->add('save',SubmitType::class, ['label'=>'Create Blog'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

          $blog = $form->getData();

          $entityManager = $this->getDoctrine()->getManager();

          $entityManager->persist($blog);

          $entityManager->flush();

          
            return $this->redirectToRoute('blog_list');

        }

        return $this->render('blog/saveBlog.html.twig', [
          'controller_name' => "Blog save",
          'form' => $form->createView()
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