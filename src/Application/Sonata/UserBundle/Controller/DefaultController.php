<?php

namespace Application\Sonata\UserBundle\Controller;

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
     * @Route("/", name="home-sonatapage")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('sonata_admin_dashboard');
    }

}
