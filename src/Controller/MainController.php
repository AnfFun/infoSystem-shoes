<?php

namespace App\Controller;

use App\Entity\Shoe;
use App\Repository\ShoeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(EntityManagerInterface $entityManager,ShoeRepository $shoeRepository): Response
    {
//        $shoeRepository->createShoe($entityManager,'Берци Wolf','Дуже круті берци, прям класні','2800','45');

        return $this->render('main.html.twig');
    }
}