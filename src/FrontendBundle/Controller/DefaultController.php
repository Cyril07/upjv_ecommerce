<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\Article;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('FrontendBundle::index.html.twig');
    }

    /**
	 * @Route("/article", name="article_presentation")
	 */
	public function articles_pageAction (Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT a
            FROM BackendBundle:Article a
            WHERE a.active = 1
            ORDER BY a.id');


        $paginator = $this->get('knp_paginator');

        $articles = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 1)/*limit per page*/
        );
		
		return $this->render('FrontendBundle::article_presentation.html.twig', array(
            'articles' => $articles,
        ));
	}

}