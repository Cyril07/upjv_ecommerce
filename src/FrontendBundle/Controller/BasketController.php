<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class BasketController extends Controller
{
    public function Action(Request $request, $id)
    {

        $session = $request->getSession();

        $basket = $session->get('basket');

        if (array_key_exists($id, $basket))
        {
            unset($basket[$id]);
            $session->set('basket', $basket);

        }
        return $this->redirect($this->generateUrl('basket'));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(Request $request, $id)
    {

        $session = $request->getSession();

        $basket = $session->get('basket');

        if (array_key_exists($id, $basket))
        {
            unset($basket[$id]);
            $session->set('basket', $basket);

        }
        return $this->redirect($this->generateUrl('basket'));
    }

    /**
     * @Route("/deletebasket", name="deletebasket")
     */
    public function deletebasketAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('basket')) $session->set('basket', []);
        $session->remove('basket');

        return $this->redirect($this->generateUrl('basket'));
    }



    /**
     * @Route("/add/{id}", name="add")
     */
    public function addAction(Request $request, $id)
    {
//        $id = $request->request->get('article_id');

        $session = $request->getSession();

    	if (!$session->has('basket')) $session->set('basket', []);
    	$basket = $session->get('basket');

        if (array_key_exists($id, $basket))
        {
            $basket[$id] += 1;
        }
        else
        {
            $basket[$id] = 1;
        }

        $session->set('basket', $basket);

        return $this->redirect($this->generateUrl('basket'));
    }

     /**
     * @Route("/panier", name="basket")
     */
    public function basketAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('basket')) $session->set('basket', []);
//        $session->remove('basket');
//        die();

//        var_dump($session->get('basket'));die();

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository("BackendBundle:Article")->findArray(array_keys($session->get('basket')));
        $command = $em->getRepository("BackendBundle:Command");

        return $this->render('FrontendBundle::basket.html.twig', array (
            'articles' => $articles,
            'command' => $command,
            'basket' => $session->get('basket'),
        ));

        //return $this->render('FrontendBundle::basket.html.twig');
    }
}