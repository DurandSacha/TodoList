<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->findAll();
        return $this->render('task/list.html.twig', [
            'tasks' => $task,
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, EntityManagerInterface $em )
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->isValid()) {
                $task->setUser($this->getUser());
                $em->persist($task);
                $em->flush();

                $this->addFlash('success', 'La tâche a été bien été ajoutée.');

                return $this->redirectToRoute('task_list');
            }
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/finished", name="task_finished")
     */
    public function task_finished()
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->findBy( array('isDone' => true) );
        return $this->render('task/list.html.twig', [
            'tasks' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(EntityManagerInterface $em, Request $request, $id)
    {
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);
        $task = $taskRepository->findOneBy(array('id' => $id));

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction($id,EntityManagerInterface $em)
    {
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);
        $task = $taskRepository->findOneBy(array('id' => $id));

        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(EntityManagerInterface $em, $id)
    {
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);
        $task = $taskRepository->findOneBy(array('id' => $id));
        $role = $this->getUser()->getRoles();

        if($role[0] == 'ROLE_ADMIN' && $task->getUser() == $this->getUser() || $task->getUser() == null){

            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'Task is deleted');
        }
        elseif($role[0] == 'ROLE_USER' && $task->getUser() == $this->getUser()){

            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'Task is deleted');
        }

        else{
            // sinon , impossible de supprimer la tache
            $this->addFlash('success', 'Impossible with your right');
        }
        return $this->redirectToRoute('task_list');
    }
}
