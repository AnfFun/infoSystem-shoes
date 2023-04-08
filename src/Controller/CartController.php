<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ShopItem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function addToCart(ShopItem $shopItem, SessionInterface $session): RedirectResponse
    {
        $cart = $session->get('cart', []);
        if (!isset($cart[$shopItem->getId()])) {
            $cart[$shopItem->getId()] = [
                'id' => $shopItem->getId(),
                'title' => $shopItem->getTitle(),
                'price' => $shopItem->getPrice(),
                'quantity' => 0,
            ];
        }

        $cart[$shopItem->getId()]['quantity']++;

        $session->set('cart', $cart);

        return $this->redirectToRoute('List');
    }

    #[Route('/cart', name: 'cart')]
    public function showCart(SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $total = 0;
        $items = [];
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $items[] = $item;
        }

        return $this->render('cart.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }
}

