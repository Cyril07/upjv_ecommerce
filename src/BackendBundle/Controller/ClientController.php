<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 * @Route("client")
 */
class ClientController extends Controller
{
    /**
     * Lists all command entities.
     *
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BackendBundle:Command')->paginationClient();

        $paginator = $this->get('knp_paginator');

        $commands = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );

        return $this->render('client/index.html.twig', array(
            'commands' => $commands,
        ));
    }
}
