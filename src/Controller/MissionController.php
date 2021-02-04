<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Mission;
use App\Form\MissionType;
use App\Form\EditMissionType;
use App\Repository\UserRepository;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MissionController extends AbstractController
{
    /**
     * @Route("/missions", name="missions")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }
        $missions = $this->getDoctrine()
        ->getRepository(Mission::class)
        ->findAll();
        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
        ]);
    }

    /**
     * @Route("/creation-mission", name="creation-mission")
     */
    public function createMission(Request $request, EntityManagerInterface $manager, UserRepository $UserRepository, MissionRepository $missionRepository): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $mission = new Mission();
        $mission->setRecruiter($user);
        $missionForm = $this->createForm(MissionType::class, $mission);
        $missionForm->handleRequest($request);
        if ($missionForm->isSubmitted() &&  $missionForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();
        }

        return $this->render('mission/create.html.twig', [
            'controller_name' => 'MissionController',
            'mission' => $mission,
            'missionForm' => $missionForm->createView(),
        ]);

    }

     /**
     * @Route("/editer-mission", name="editer-mission")
     */
    public function editMission( Request $request,EntityManagerInterface $manager): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }

        $mission = new Mission();
        $mission->setRecruiter($user);
        
        $editMissionType = $this->createForm(EditMissionType::class, $mission);
        $editMissionType->handleRequest($request);
        if ($editMissionType->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();
        }

        return $this->render('mission/edit.html.twig', [
            'controller_name' => 'MissionController',
            'editMissionType' => $editMissionType->createView(),
            'mission' => $mission,
        ]);
    }
}
