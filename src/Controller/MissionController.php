<?php

namespace App\Controller;

use App\Entity\Mission;
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
}
