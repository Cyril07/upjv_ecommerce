<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function Symfony\Component\DependencyInjection\Tests\Fixtures\factoryFunction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use BackendBundle\Entity\Basket;
use BackendBundle\Entity\Command;


class BasketController extends Controller
{

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
     * @Route("/push", name="push")
     */
    public function pushAction(Request $request)
    {
        $nom = $request->request->get('nom');
        $fn = $request->request->get('fn');
        $email = $request->request->get('email');

        //var_dump($name);die;
        $session = $request->getSession();
        $basket_session = $session->get('basket');

        $em = $this->getDoctrine()->getManager();

        if ($nom!=null && $fn!=null && $email!= null) {
            $now = new \DateTime('now');
            $command = new Command();
            $command->setDateCommand($now);
            $command->setLastname($nom);
            $command->setFirstname($fn);
            $command->setEmail($email);
            $command->setStatus(0);

            $em->persist($command);
            $em->flush();

            $articles = $em->getRepository('BackendBundle:Article')->findArray(array_keys($basket_session));
            $last_id_command = $em->getRepository('BackendBundle:Command')->findLast();

            foreach ($articles as $article) {
                $basket = new Basket();
                $basket->setArticle($article);
                $basket->setQuantity($basket_session[$article->getId()]);
                $basket->setCommand($last_id_command);
                $em->persist($basket);
                $em->flush();
            }
            $session->remove('basket');

            $message = (new \Swift_Message('Ecommerce : Validation de votre commande'))
                ->setFrom(array('cy.lenglet@laposte.net' => 'Ecommerce UPJV'))
                ->setTo($email)
                ->setContentType('text/html')
                ->setBody($this->renderView('Emails/confirmed_order.html.twig',
                    array(
                        'nom' => $nom,
                        'fn' => $fn,
                        'articles' => $articles,
                        'basket' => $basket_session,
                    )
                ));

            $this->get('mailer')->send($message);

        }

        return $this->redirect($this->generateUrl('basket'));
    }

     /**
     * @Route("/panier", name="basket")
     */
    public function basketAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('basket')) $session->set('basket', []);
        $basket = $session->get('basket');
//        $session->remove('basket');
//        die();

//        var_dump($session->get('basket'));die();

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository("BackendBundle:Article")->findArray(array_keys($session->get('basket')));
        $command = $em->getRepository("BackendBundle:Command");

        return $this->render('FrontendBundle::basket.html.twig', array (
            'articles' => $articles,
            'basket' => $session->get('basket'),
        ));
    }

    /**
     * @Route("/qty", name="qty")
     */
    public function qtyAction(Request $request)
    {
        $id = $request->request->get('article_id');
        $qty = $request->request->get('qty');

        $session = $request->getSession();

        if (!$session->has('basket')) $session->set('basket', []);
        $basket = $session->get('basket');

        if (array_key_exists($id, $basket))
        {
            $basket[$id] = $qty;
        }

        $session->set('basket', $basket);

        return $this->redirect($this->generateUrl('basket'));
    }
}