<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(UserRepository $repo): Response
    {
        $users=$repo->findAll();
        return $this->render('user/index.html.twig', [
            'users'=> $users

        ]);
    }

    /**
     * @Route("/users/{id}", name="users_edit")
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager): Response
    {

        // dd($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() & $form->isValid()){
            if($user->getPlainpassword()){
                $pwd = $encoder->encodePassword($user, $user->getPlainpassword());
                $user->setPassword($pwd);
            }

            // dd($user);
            $manager->persist($user);
            $manager->flush();

        }
    
        return $this->render('user/view.html.twig', [

            'form'=> $form->createView()

        ]);
    }




}
