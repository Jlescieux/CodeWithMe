<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProjectRepository $projectRepository)
    {

        // nous récupérons les 3 premiers projets en fonction du nombre de "likes"
        $bestProjects = $projectRepository->findBy(
            [],
            ['nbLikes' => 'DESC'],
            3
        );

        return $this->render('home/home.html.twig', [
            'bestProjects' => $bestProjects,
        ]);
    }
}
