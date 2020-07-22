<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Spectator;
use App\Form\SpectatorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(Request $request)
    {
        $spectator = new Spectator();
        $form = $this->createForm(SpectatorType::class, $spectator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbrPlace = $spectator->getBooking()->getPlace();
            if ($nbrPlace > 0) {
                $spectator->setFirstname($spectator->getFirstname());
                $spectator->setLastname($spectator->getLastname());
                $spectator->setBooking($spectator->getBooking());
                $spectator->getBooking()->setPlace($nbrPlace - 1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($spectator);
                $em->flush();
            } else {
                return $this->render('booking/index.html.twig',[
                    'form' => $form->createView(),
                    'errorNbrPlace' => 'Le spectacle est complet'
                ]);
            }
        }
        return $this->render('booking/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
