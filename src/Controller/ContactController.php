<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
    $form= $this->createForm(ContactType::class);


    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

$contact= $form->getData();
$message = (new \Swift_Message('Mail de : '.$contact["nom"]))
        ->setFrom($contact["mail"])
        ->setTo("xxxraviel18gxxx@gmail.com")
        ->setBody($this->renderView(
            // templates/emails/registration.txt.twig
            'email/email.html.twig',
            ['contact' => $contact]
        ),
        'text/html'
    )
           
        ;
        $mailer->send($message);




    }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
