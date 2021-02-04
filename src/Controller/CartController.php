<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, UserRepository $candidateRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('home');
        }

        $cart = $session->get('cart', []);

        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'candidate' => $candidateRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $couple) {
            $total += $couple['candidate']->getPrice() * $couple['quantity'];
        }

        return $this->render('cart/index.html.twig', [
            "items" => $cartWithData,
            "total" => $total
        ]);
    }

    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $session->set('cart', $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

     /**
     * @Route("/success", name="success")
     */
    public function success(Request $request, SessionInterface $session): Response
    {
        $this->addFlash(
            'notice',
            'Le candidat a été contacté avec succès !'
        );
        $session->remove('cart');
        return $this->redirectToRoute('candidats');
    }


     /**
     * @Route("/error", name="error")
     */
    public function error() 
    {
        return $this->render('cart/error.html.twig');
    }

}