<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/test/user", name="userpage")
     */
    public function testUserAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response('welcome User');
    }

    /**
     * @Route("/test/admin", name="adminpage")
     */
    public function testAdminAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return new Response('welcome Admin');
    }
}
