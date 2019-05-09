<?php

namespace App\Controller;

use App\Entity\Task;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task_success")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $repository->findAll();

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/task/new", name="newTask")
     */

    public function new(Request $request){



        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task',TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save',SubmitType::class, ['label'=>'Create Task'])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($task);

            $entityManager->flush();
            

            return $this->redirectToRoute('task_success');


        }

        return $this->render('task/new.html.twig', [
            'controller_name' => $task->getTask(),
            'form' => $form->createView()
        ]);

    }
}
