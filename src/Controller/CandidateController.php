<?php

namespace App\Controller;

use App\Entity\User;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidateController extends AbstractController
{
    /**
     * @Route("/candidats", name="candidats")
     */
    public function index(UserRepository $userRepository, Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $users = $userRepository->findSearch($data);
        return $this->render('candidate/index.html.twig',[
                'users' => $users,
                'form' => $form->createView(),
        ]);
    }
}
