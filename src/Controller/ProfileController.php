<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
        ]);
    }


    /**
     * @Route("/editer", name="editer")
     */
    public function editProfil( Request $request,EntityManagerInterface $manager): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        $profileForm = $this->createForm(EditProfileType::class, $user);
        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('profile/edit.html.twig', [
            'controller_name' => 'ProfileController',
            'profileForm' => $profileForm->createView(),
            'user' => $user,
        ]);
    }
}
