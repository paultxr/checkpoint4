<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidats", name="candidats")
     */
    public function index(): Response
    {
        $candidates = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
        return $this->render('candidate/index.html.twig', [
            'candidates' => $candidates,
        ]);
    }
}
