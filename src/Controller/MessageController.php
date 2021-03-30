<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    /**
     * @Route("/send", name="send")
     */


    public function send(Request $request): Response
    {

        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($message);
            $manager->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }

        return $this->render('message/send.html.twig', [

            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        return $this->render('message/received.html.twig');
    }

    /**
     * pour les éléments envoyés
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        return $this->render('message/sent.html.twig');
    }


    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        //    supper ! 
        $message->setIsRead(true);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($message);
        $manager->flush();
        return $this->render('message/read.html.twig');
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Messages $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }
}
