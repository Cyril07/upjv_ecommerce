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

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BackendBundle:Command')->pagination('c.status', 'ASC');

        $paginator = $this->get('knp_paginator');

        $commands = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,
        ));
    }

    /**
     * @Route("/status", name="command_status")
     */
    public function statusOkAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BackendBundle:Command')->pagination('c.status', 'DESC');

        $paginator = $this->get('knp_paginator');

        $commands = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,
        ));
    }

    /**
     * @Route("/date", name="command_date")
     */
    public function commandDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BackendBundle:Command')->pagination('c.dateCommand', 'DESC');

        $paginator = $this->get('knp_paginator');

        $commands = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,
        ));
    }

    /**
     * @Route("/command/lastname", name="command_lastname")
     */
    public function commandLastnameAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('BackendBundle:Command')->pagination('c.lastname', 'DESC');

        $paginator = $this->get('knp_paginator');

        $commands = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );

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
            ->setTo($command->getEmail())
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
