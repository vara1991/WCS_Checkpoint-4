<?php

namespace App\Controller;

use App\Entity\Spectator;
use App\Form\SpectatorType;
use App\Repository\SpectatorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(Request $request, MailerInterface $mailer)
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

                $email = (new TemplatedEmail())
                    ->from('varaponegaire@gmail.com')
                    ->to($spectator->getEmail())
                    ->subject('Réservation')
                    ->htmlTemplate('booking/email.html.twig')
                    ->context([
                        'firstname' => $spectator->getFirstname(),
                        'lastname' => $spectator->getLastname(),
                        'booking' => $spectator->getBooking()->getStart(),
                    ]);
                $mailer->send($email);

                $this->addFlash('success', 'Votre réservation a été pris en compte !');
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

    /**
     * @Route("/booking/cancel-form", name="cancel_form_booking")
     */
    public function cancelForm(SpectatorRepository $spectatorRepository)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email =$spectatorRepository->findOneBy(['email'=>$_POST['email']]);
            if(isset($email)){
                return $this->redirectToRoute('cancel_booking',[
                    'id'=> $email->getId(),
                ]);
            }else{
                return $this->render('booking/cancel-form.html.twig',[
                    'errorMail' => 'Vous n\'avez pas de réservation'
                ]);
            }

        }
        return $this->render('booking/cancel-form.html.twig');
    }

    /**
     * @Route("/booking/cancel/{id}", name="cancel_booking")
     */
    public function cancel(Request $request, Spectator $spectator)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $nbrPlace = $spectator->getBooking()->getPlace();
            $addPlace = $spectator->getBooking()->setPlace($nbrPlace + 1);
            $entityManager->persist($addPlace);
            $entityManager->remove($spectator);
            $entityManager->flush();
            $this->addFlash('success', 'Votre réservation a été annulé !');
            return $this->redirectToRoute('home');
        }

        return $this->render('booking/cancel.html.twig',[
            'firstname'=>$spectator->getFirstname(),
            'lastname'=>$spectator->getLastname(),
            'email'=>$spectator->getEmail(),
            'booking'=>$spectator->getBooking()->getStart(),
        ]);
    }

}
