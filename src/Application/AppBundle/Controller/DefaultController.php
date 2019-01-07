<?php

namespace Application\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends Controller
{
    // php bin/console fos:user:create testuser test@example.com p@ssword
    // php bin/console fos:user:promote testuser ROLE_ADMIN

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/users/list", name="userspage")
     */
    public function userListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ApplicationSonataUserBundle:User')->findAll();
        return $this->render('default/users.html.twig', [
            'users' => $users
        ]);
    }

}
