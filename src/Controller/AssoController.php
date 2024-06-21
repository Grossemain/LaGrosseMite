<?php

namespace App\Controller;

use App\Entity\Asso;
use App\Form\AssoType;
use App\Repository\AssoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/asso')]
class AssoController extends AbstractController
{
    #[Route('/', name: 'app_asso_index', methods: ['GET'])]
    public function index(AssoRepository $assoRepository): Response
    {
        return $this->render('asso/index.html.twig', [
            'assos' => $assoRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: 'app_asso_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $asso = new Asso();
    //     $form = $this->createForm(AssoType::class, $asso);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($asso);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_asso_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('asso/new.html.twig', [
    //         'asso' => $asso,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_asso_show', methods: ['GET'])]
    public function show(Asso $asso): Response
    {
        return $this->render('asso/show.html.twig', [
            'asso' => $asso,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_asso_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Asso $asso, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssoType::class, $asso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_asso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('asso/edit.html.twig', [
            'asso' => $asso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_asso_delete', methods: ['POST'])]
    public function delete(Request $request, Asso $asso, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$asso->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($asso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_asso_index', [], Response::HTTP_SEE_OTHER);
    }
}
