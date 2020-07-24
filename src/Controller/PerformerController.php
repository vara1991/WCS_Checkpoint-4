<?php

namespace App\Controller;

use App\Repository\PerformerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PerformerController extends AbstractController
{
    /**
     * @Route("/performer", name="performer")
     */
    public function index(PerformerRepository $performerRepository)
    {
        return $this->render('performer/index.html.twig',[
            'performers' => $performerRepository -> findAll(),
        ]);
    }
}
