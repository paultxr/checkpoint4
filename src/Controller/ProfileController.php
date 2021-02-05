<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Mission;
use App\Form\EditProfileType;
use App\Repository\MissionRepository;
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
    public function index(Request $request, EntityManagerInterface $manager, MissionRepository $missionRepository): Response
    {

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }

        $missions = $this->getDoctrine()
        ->getRepository(Mission::class)
        ->findAll();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'missions' => $missions,
        ]);
    }


    /**
     * @Route("/editer", name="editer")
     */
    public function editProfil( Request $request,EntityManagerInterface $manager): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }
        
        $profileForm = $this->createForm(EditProfileType::class, $user);
        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted()) {
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
