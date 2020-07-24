<?php

namespace App\Controller;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = (new TemplatedEmail())
                ->from('varaponegaire@gmail.com')
                ->to('varaponegaire@gmail.com')
                ->subject($data['object'])
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    'civility' => $data['civility'],
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'object'=> $data['object'],
                    'message' => $data['message']
            ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé !');

        }

        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
