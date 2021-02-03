<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Mission;
use App\Form\MissionType;
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
    public function index(): Response
    {
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
    public function createMission( Request $request,EntityManagerInterface $manager): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // $mission = $this->getMission();
        
        $missionForm = $this->createForm(MissionType::class);
        $missionForm->handleRequest($request);
        if ($missionForm->isSubmitted() &&  $missionForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();
        }

        return $this->render('mission/create.html.twig', [
            'controller_name' => 'MissionController',
            'missionForm' => $missionForm->createView(),
        ]);
    }
}
