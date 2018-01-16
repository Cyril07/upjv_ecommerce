<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Article;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $query = $em->getRepository('BackendBundle:Article')->pagination('a.id');

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

    /**
     * @Route("/article/prix", name="article_price")
     */
    public function article_priceAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('BackendBundle:Article')->pagination('a.price');

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

    /**
     * @Route("/article/designation", name="article_designation")
     */
    public function article_designationAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('BackendBundle:Article')->pagination('a.wording');

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

    /**
     * @Route("/article/disponibilite", name="article_stock")
     */
    public function article_stockAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('BackendBundle:Article')->pagination('a.stock', 'DSC');

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