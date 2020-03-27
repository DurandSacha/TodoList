<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('task/list.html.twig', [
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
        //TODO: on ne peut supprimer que sa propre tache // les admin peuvent supprimer leurs taches et les anonymes
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);
        $task = $taskRepository->findOneBy(array('id' => $id));

        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
