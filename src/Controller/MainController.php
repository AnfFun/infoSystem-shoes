<?php

namespace App\Controller;

use App\Entity\ShopItem;
use App\Repository\ShopItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('homepage.html.twig');
    }

    #[Route('/shop/list', name: 'list')]
    public function shopList(ShopItemRepository $shopItemRepository): Response
    {
        $result = $shopItemRepository->findAll();

        return $this->render('shop-list.html.twig', [
            'shoes' => $result,
        ]);
    }


    #[Route('/shop/item{id<\d+>}', name: 'shop_item')]
    public function shopItem(ShopItem $shopItem, ShopItemRepository $shopItemRepository): Response
    {
        $result = [$shopItem];

        return $this->render('shop-item.html.twig', [
            'title' => $shopItem->getTitle(),
            'description' => $shopItem->getDescription(),
            'price' => $shopItem->getPrice(),
            'shoes' => $result,
        ]);
    }

    #[Route('/cart', name: 'cart')]
    public function cart(SessionInterface $session, ShopItemRepository $shopItemRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $item = $shopItemRepository->find($id);

            if (!$item) {
                continue;
            }

            $price = is_numeric($item->getPrice()) ? $item->getPrice() : (float) str_replace(',', '.', $item->getPrice());
            $itemTotal = $price * intval($quantity);

            $cartItems[] = [
                'item' => $item,
                'quantity' => $quantity,
                'itemTotal' => $itemTotal,

            ];

            $total += $itemTotal;
        }

        return $this->render('cart.html.twig', [
            'cartItems' => $cartItems,
            'cartTotal' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function addToCart(Request $request, int $id, ShopItemRepository $shopItemRepository): RedirectResponse
    {
        $cart = $request->getSession()->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $request->getSession()->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/clear', name: 'clear_cart')]
    public function clearCart(Request $request): RedirectResponse
    {
        $request->getSession()->remove('cart');

        return $this->redirectToRoute('cart');
    }


}

