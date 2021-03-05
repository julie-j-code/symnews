<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * En pratique, cette route devrait être transférée dans un dossier admin
     * @Route("/users/{id}", name="users_edit")
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager): Response
    {

        // dd($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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

    /**
     * Préférable si on ne souhaite pas que tout utilisateur puisse modifier tous les utilisateurs !
     * @Route("/users/profile/edit", name="profile_edit")
     */
    public function editProfile(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager): Response
    {

        // dd($user);
        $user=$this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($user->getPlainpassword()){
                $pwd = $encoder->encodePassword($user, $user->getPlainpassword());
                $user->setPassword($pwd);
            }

            // dd($user);
            $manager->persist($user);
            $manager->flush();

        }
    
        return $this->render('user/view.html.twig', [
            'user'=>$user,

            'form'=> $form->createView()

        ]);
    }




}
