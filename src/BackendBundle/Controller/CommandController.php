<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Command controller.
 *
 * @Route("command")
 */
class CommandController extends Controller
{
    /**
     * Lists all command entities.
     *
     * @Route("/", name="command_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commands = $em->getRepository('BackendBundle:Command')->findAll();

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,

        ));
    }

    /**
     * @Route("/send/{id}", name="send")
     */
    public function sendAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $command = $em->getRepository('BackendBundle:Command')->find($id);
        $command->setStatus(1);
        $em->persist($command);
        $em->flush();

        $message = (new \Swift_Message('Ecommerce : Envoie de votre commande'))
            ->setFrom(array('cy.lenglet@laposte.net' => 'Ecommerce UPJV'))
            ->setTo($email)
            ->setContentType('text/html')
            ->setBody($this->renderView('Emails/send_order.html.twig',
                array(
                    'command' => $command,
                )
            ));

        $this->get('mailer')->send($message);



        return $this->redirect($this->generateUrl('command_index'));
    }




    /**
     * Creates a new command entity.
     *
     * @Route("/new", name="command_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $command = new Command();
        $form = $this->createForm('BackendBundle\Form\CommandType', $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            return $this->redirectToRoute('command_show', array('id' => $command->getId()));
        }

        return $this->render('command/new.html.twig', array(
            'command' => $command,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a command entity.
     *
     * @Route("/{id}", name="command_show")
     * @Method("GET")
     */
    public function showAction(Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);

        return $this->render('command/show.html.twig', array(
            'command' => $command,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing command entity.
     *
     * @Route("/{id}/edit", name="command_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);
        $editForm = $this->createForm('BackendBundle\Form\CommandType', $command);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('command_edit', array('id' => $command->getId()));
        }

        return $this->render('command/edit.html.twig', array(
            'command' => $command,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a command entity.
     *
     * @Route("/{id}", name="command_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Command $command)
    {
        $form = $this->createDeleteForm($command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($command);
            $em->flush();
        }

        return $this->redirectToRoute('command_index');
    }

    /**
     * Creates a form to delete a command entity.
     *
     * @param Command $command The command entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Command $command)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('command_delete', array('id' => $command->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
