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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/ressource')]
final class RessourceController extends AbstractController
{
    #[Route('/', name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        $ressources = $ressourceRepository->findAll();

        return $this->render('ressource/index.html.twig', [
            'ressources' => $ressources,
        ]);
    }

    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $pdfFile */
            $pdfFile = $form->get('pdfressource')->getData();

            if ($pdfFile) {
                try {
                    $newFilename = $this->handleFileUpload($pdfFile, $slugger);
                    $ressource->setPdfressource($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement du fichier.');
                }
            }

            $em->persist($ressource);
            $em->flush();

            $this->addFlash('success', 'Ressource créée avec succès.');
            return $this->redirectToRoute('app_ressource_index');
        }

        return $this->render('ressource/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(?Ressource $ressource): Response
    {
        if (!$ressource) {
            throw $this->createNotFoundException('Ressource non trouvée.');
        }

        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfFile = $form->get('pdfressource')->getData();

            if ($pdfFile) {
                try {
                    $newFilename = $this->handleFileUpload($pdfFile, $slugger);
                    $ressource->setPdfressource($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload du fichier.');
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Ressource mise à jour avec succès.');
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ressource/edit.html.twig', [
            'form' => $form->createView(),
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ressource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ressource);
            $entityManager->flush();

            $this->addFlash('success', 'Ressource supprimée avec succès.');
        }

        return $this->redirectToRoute('app_ressource_index');
    }

    #[Route('/uploads/pdf/{filename}', name: 'app_file_download')]
    public function downloadFile(string $filename): Response
    {
        $filePath = $this->getParameter('uploads_directory') . '/pdf/' . $filename;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Le fichier n\'existe pas.');
        }

        return $this->file($filePath, null, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }

    #[Route('/uploads/pdf/show/{filename}', name: 'app_examen_show_pdf')]
    public function showPdf(string $filename): Response
    {
        $publicUrl = $this->getParameter('show_pdf') . $filename;
        return $this->redirect($publicUrl);
    }

    private function handleFileUpload(UploadedFile $file, SluggerInterface $slugger): string
    {
        // Dossier de téléchargement des fichiers
        $uploadDirectory = $this->getParameter('uploads_directory') . '/pdf';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        // Vérifier que l'extension du fichier est PDF
        if ($file->guessExtension() !== 'pdf') {
            throw new FileException('Seuls les fichiers PDF sont autorisés.');
        }

        // Déplacer le fichier dans le répertoire de téléchargement
        $file->move($uploadDirectory, $newFilename);

        return $newFilename;
    }
}
