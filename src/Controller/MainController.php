<?php

namespace App\Controller;

use App\Entity\Shoe;
use App\Entity\ShopItem;
use App\Repository\CustomerRepository;
use App\Repository\ShoeRepository;
use App\Repository\ShopItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    public function debug($data)
    {
        echo '<pre>' . print_r($data) . '</pre>';
    }

    #[Route('shop/list', name: 'List')]
    public function shopList(EntityManagerInterface $entityManager, ShopItemRepository $shopItemRepository): Response
    {
//        $shopItemRepository->itemCreate($entityManager,'Boots','1200','Hello');
//        $this->debug($result);
        $result = $shopItemRepository->findAll();
//        dd($result);
        return $this->render('shop-list.html.twig', [
            'shoes' => $result,
        ]);
    }

    /**
     * @param int $shopItem
     * @return Response
     */
    #[Route('/shop/item{id<\d+>}',name: 'shopItem')]
    public function shopItem(ShopItem $shopItem, EntityManagerInterface $entityManager, ShopItemRepository $shopItemRepository){
        $result = $shopItemRepository->findAll();
        return $this->render('shop-item.html.twig',[
            'title' => $shopItem->getTitle(),
            'description'=>$shopItem->getDescription(),
            'price' =>$shopItem->getPrice(),
            'shoes' => $result,
        ]);
    }

    #[Route('/',name: 'Home')]
    public function homepage():Response
    {
      return  $this->render('homepage.html.twig');
    }

    #[Route('/cart',name: 'cart')]
    public function cartpage(Request $request, ShopItemRepository $shopItemRepository): Response
    {
        $cart = $request->getSession()->get('cart', []);
        $cartItems = [];
        foreach ($cart as $id => $quantity) {
            $item = $shopItemRepository->find($id);
            if (!$item) {
                continue;
            }
            $cartItems[] = [
                'item' => $item,
                'quantity' => $quantity,
            ];
        }
        $cartTotal = $this->cartTotal($cartItems);
        return $this->render('cart.html.twig', [
            'cartItems' => $cartItems,
            'cartTotal' => $this->cartTotal($cartItems),
        ]);
    }


    #[Route('/cart/add/{id}', name: 'addToCart')]
    public function addToCart(Request $request, $id)
    {
        $cart = $request->getSession()->get('cart', []);
        if (!isset($cart[$id])) {
            $cart[$id] = 0;
        }
        $cart[$id]++;
        $request->getSession()->set('cart', $cart);
        return $this->redirectToRoute('cart');
    }

    // Returns total cart value
    public function cartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $price = is_numeric($item['item']->getPrice()) ? $item['item']->getPrice() : (float) str_replace(',', '.', $item['item']->getPrice());
            $total += $price * intval($item['quantity']);
        }
        return $total;
    }


}
