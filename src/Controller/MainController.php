<?php

namespace App\Controller;

use App\Entity\Shoe;
use App\Repository\CustomerRepository;
use App\Repository\ShoeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function debug($data){
        echo '<pre>' . print_r($data) . '</pre>';
    }
    #[Route('/',name: 'Home')]
    public function homepage(EntityManagerInterface $entityManager): Response
    {
//        $this->debug($result);
        return $this->render('main.html.twig',[
//            'shoes' => $result,
        ]);
    }
}
