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
	public function article_pageAction (Request $request)
	{
		$em = $this->getDoctrine()->getManager();


        if ($filter = $request->request->get('filter') == null)
        {
            $filter ='a.id';
        }

        $query = $em->getRepository('BackendBundle:Article')->pagination($filter);

        $paginator = $this->get('knp_paginator');

        //var_dump($filter);die;
        $articles = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)/*limit per page*/
        );

		return $this->render('FrontendBundle::article_presentation.html.twig', array(
            'articles' => $articles,
        ));
	}

}

