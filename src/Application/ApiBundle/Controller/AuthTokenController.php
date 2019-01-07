<?php
namespace Application\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use Application\ApiBundle\Form\CredentialsType;
use Application\ApiBundle\Entity\AuthToken;
use Application\ApiBundle\Entity\Credentials;

class AuthTokenController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Post("/login")
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $userRepo = $em->getRepository('ApplicationSonataUserBundle:User');
        $user = $userRepo->findOneByEmail($credentials->getLogin());

        if (!$user) {
            $user = $userRepo->findOneByUsername($credentials->getLogin());
        }
        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        return $authToken;
    }

    /**
     * @Rest\View()
     * @Rest\Delete("/logout")
     */
    public function removeAuthTokenAction(Request $request)
    {
        $headers = $request->headers->all();
        $token = $headers['x-auth-token'][0];
        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $em->getRepository('ApiBundle:AuthToken')
                    ->findOneBy(array('value'=>$token));
        /* @var $authToken AuthToken */

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();
        $userId = $connectedUser->getId();
        if ($authToken && $authToken->getUser()->getId() === $userId) {
            
            $authTokens = $em->getRepository('ApiBundle:AuthToken')
                    ->findBy(array('user'=>$userId));

            foreach($authTokens as $token){
                $em->remove($token);
            }
            $em->flush();
            return \FOS\RestBundle\View\View::create(['message' => 'done'], Response::HTTP_OK);
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }


    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }
}
