<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Mission;
use App\Repository\MissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartMissionController extends AbstractController
{
    /**
     * @Route("/cartmission", name="cartmission_index")
     */
    public function index(SessionInterface $session, MissionRepository $missionRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }

        $cartMission = $session->get('cartMission', []);

        $cartMissionWithData = [];

        foreach ($cartMission as $id => $quantity) {
            $cartMissionWithData[] = [
                'mission' => $missionRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartMissionWithData as $couple) {
            $total += $couple['mission']->getPrice() * $couple['quantity'];
        }

        return $this->render('cartMission/index.html.twig', [
            "items" => $cartMissionWithData,
            "total" => $total
        ]);
    }

    /**
     * @Route("/addmission/{id}", name="cartmission_add")
     */
    public function addMission($id, SessionInterface $session)
    {
        $cartMission = $session->get('cartMission', []);

        if (empty($cartMission[$id])) {
            $cartMission[$id] = 0;
        }

        $cartMission[$id]++;

        $session->set('cartMission', $cartMission);

        return $this->redirectToRoute("cartmission_index");
    }

    /**
     * @Route("/deletemission/{id}", name="cartmission_remove")
     */
    public function removeMission($id, SessionInterface $session)
    {
        $cartMission = $session->get('cartMission', []);

        if (!empty($cartMission[$id])) {
            unset($cartMission[$id]);
        }

        $session->set('cartMission', $cartMission);

        return $this->redirectToRoute('cartMission_index');
    }

     /**
     * @Route("/successmission", name="successmission")
     */
    public function successMission(Request $request, SessionInterface $session): Response
    {
        $this->addFlash(
            'notice',
            'Le recruteur a été contacté avec succès !'
        );
        $session->remove('cartMission');
        return $this->redirectToRoute('missions');
    }


     /**
     * @Route("/error", name="error")
     */
    public function error() 
    {
        return $this->render('cartMission/error.html.twig');
    }

}