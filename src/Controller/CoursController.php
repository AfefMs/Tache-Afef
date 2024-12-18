<?php
namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;  
use App\Repository\CoursRepository;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    private ValidatorInterface $validator;  

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(Request $request, CoursRepository $coursRepository): Response
    {
        $searchTerm = $request->query->get('search', '');

        if ($searchTerm) {
            $cours = $coursRepository->findBySearchTerm($searchTerm);
        } else {
            $cours = $coursRepository->findAll();
        }

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validator->validate($cours);

            if (count($errors) > 0) {
                return $this->render('cours/error.html.twig', [
                    'errors' => $errors,
                ]);
            }

            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cours' => $cours,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cours): Response
    {
        return $this->render('cours/show.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validator->validate($cours);

            if (count($errors) > 0) {
                return $this->render('cours/error.html.twig', [
                    'errors' => $errors,
                ]);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cours' => $cours,
            'form' => $form,
        ]);
    }

    // Méthode pour supprimer un cours et ses ressources associées
    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si le token CSRF est valide avant de supprimer
        if ($this->isCsrfTokenValid('delete' . $cours->getId(), $request->request->get('_token'))) {
            // Supprimer toutes les ressources associées à ce cours
            foreach ($cours->getRessources() as $ressource) {
                $entityManager->remove($ressource); // Supprime chaque ressource liée au cours
            }
            $entityManager->remove($cours); // Supprime le cours lui-même
            $entityManager->flush(); // Valide toutes les suppressions
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
