<?php

namespace Application\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends Controller
{
    // php bin/console fos:user:create testuser test@example.com p@ssword
    // php bin/console fos:user:promote testuser ROLE_ADMIN

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('default/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/{slug}", name="page")
     */
    public function pageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        $pages = $em->getRepository('AppBundle:Page')->findAll();

        foreach ($pages as $page){
            $slug[] = $page->getSlug();
        }
        for ($i = 0; $i < count($slug); $i++) { 
            $url[] = $this->generateUrl('page', array('slug'=>$slug[$i]));  
        }
        if (!in_array($request->getRequestUri(), $url)) {
            throw $this->createNotFoundException('This page does not exist');
        }
        
        return $this->render('default/page.html.twig', array (
            "products" => $products,
            'pages' => $pages,
        ));
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/users/list", name="userspage")
     */
    public function userListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('default/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/me", name="user")
     */
    public function usersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('AppBundle:Booking')->findAll();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('default/users.html.twig', [
            'users' => $users,
            'bookings'=> $booking
        ]);
    }

}
