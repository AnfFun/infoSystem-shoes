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
    public function shopItem(ShopItem $shopItem){
        return $this->render('shop-item.html.twig',[
            'title' => $shopItem->getTitle(),
            'description'=>$shopItem->getDescription(),
            'price' =>$shopItem->getPrice(),
        ]);
    }

    #[Route('/',name: 'Home')]
    public function homepage():Response
    {
      return  $this->render('homepage.html.twig');
    }
}
