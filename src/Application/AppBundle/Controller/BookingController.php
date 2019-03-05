<?php

namespace Application\AppBundle\Controller;

use Application\AppBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Booking controller.
 *
 * @Route("agenda")
 * @ParamConverter("event", options={"mapping":{"id":"id"}});
 */
class BookingController extends Controller
{
    /**
     * Lists all booking entities.
     *
     * @Route("/", name="booking_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('booking/index.html.twig');
    }

    /**
     * Creates a new booking entity.
     *
     * @Route("/", name="booking_index")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, \Swift_Mailer $mailer)
    {
        $booking = new Booking();
        $form = $this->createForm('Application\AppBundle\Form\BookingType', $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            $message = (new \Swift_Message('Nouvelle reservation !'))
            ->setFrom('send@example.com')
            ->setTo('david.guyomard@live.fr')
            ->setBody(
                $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                    'emails/new_event.email.twig',
                    [
                        'date_reservation' => $booking->getBeginAt(),
                        'type_reservation' => $booking->getTitle()
                    ]
                ),
                'text/html'
            );

            $mailer->send($message);
            return $this->redirectToRoute('booking_index', array(
                'id' => $booking->getId()
            ));
            
        }

        return $this->render('booking/index.html.twig', array(
            'booking' => $booking,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a booking entity.
     *
     * @Route("/{id}", name="booking_show")
     * @Method("GET")
     */
    public function showAction(Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);

        return $this->render('booking/show.html.twig', array(
            'booking' => $booking,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing booking entity.
     *
     * @Route("/{id}/edit", name="booking_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);
        $editForm = $this->createForm('Application\AppBundle\Form\BookingType', $booking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_edit', array('id' => $booking->getId()));
        }

        return $this->render('booking/edit.html.twig', array(
            'booking' => $booking,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a booking entity.
     *
     * @Route("/{id}/delete", name="booking_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Booking $booking)
    {
        $form = $this->createDeleteForm($booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($booking);
            $em->flush();
        }

        return $this->redirectToRoute('booking_index');
    }

    /**
     * Creates a form to delete a booking entity.
     *
     * @param Booking $booking The booking entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Booking $booking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('booking_delete', array('id' => $booking->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
