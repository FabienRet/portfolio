<?php

namespace App\Controller;

use App\Repository\MyInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function cv(MyInfoRepository $myInfoRepository){

        $myInfos = $myInfoRepository->findAll();
        return $this->render('front/cv.html.twig', [
            'myInfos' => $myInfos
        ]);
    }
}
