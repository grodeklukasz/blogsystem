<?php
    // src/Controller/LuckyController.php
    namespace App\Controller;
    

    //for Response 1)

    use Symfony\Component\HttpFoundation\Response;

    //for Annotation a Route 2)

    use Symfony\Component\Routing\Annotation\Route;

    //for render function 3)

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class LuckyController extends AbstractController{
        
        //2)

        /**
         * @Route("/lucky/number")
         */

        public function number(){
            $number = random_int(0,100);

            $numbeData = array(
                "1"=>$number
            );

            $entries = array(
                
                    'title' => 'blog',
                    'body' => 'bodies'
             
            );

            //1)
            /*
            return new Response(
                '<html><body>Lucky numbers:<pre>'.print_r($numbeData).'</pre></body></html>'
            );
            */

            //3)

            return $this->render('lucky/number.html.twig',[
                'number' => $number,
                'entries' => $entries
            ]);



        }

    }

?>