<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        // Utiliser le repository pour récupérer les ressources
        $ressources = $ressourceRepository->findAll();

        return $this->render('front.html.twig', [
            'ressources' => $ressources,
        ]);
    }
}





