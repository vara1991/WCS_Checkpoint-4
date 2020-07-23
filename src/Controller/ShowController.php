<?php

namespace App\Controller;

use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index(ShowRepository $showRepository)
    {
        return $this->render('show/index.html.twig',[
            'shows' => $showRepository->findAll(),
        ]);
    }
}
