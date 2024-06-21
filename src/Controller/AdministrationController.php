<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Members;
use App\Form\MembersType;
use App\Entity\Asso;
use App\Form\AssoType;
use App\Entity\Sections;
use App\Form\SectionsType;
use App\Entity\Teams;
use App\Form\TeamsType;
use App\Repository\MembersRepository;
use App\Repository\AssoRepository;
use App\Repository\SectionsRepository;
use App\Repository\TeamsRepository;


#[Route('/administration')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'app_administration')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('administration/index.html.twig', [
            'administrateur_name' => 'Romain',
        ]);
    }
    
    //crud administration Asso//

    #[Route('/asso', name: 'app_admin_asso_index', methods: ['GET'])]
    public function indexAsso(AssoRepository $assoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('administration/adminAsso.html.twig', [
            'assos' => $assoRepository->findAll(),
        ]);
    }

    #[Route('/asso/new', name: 'app_admin_asso_new', methods: ['GET', 'POST'])]
    public function newAsso(Request $request, EntityManagerInterface $entityManager): Response
    {
        $asso = new Asso();
        $form = $this->createForm(AssoType::class, $asso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($asso);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_asso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('asso/new.html.twig', [
            'asso' => $asso,
            'form' => $form,
        ]);
    }

    #[Route('/asso/{id}/edit', name: 'app_admin_asso_edit', methods: ['GET', 'POST'])]
    public function editAsso(Request $request, Asso $asso, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssoType::class, $asso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_asso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('asso/edit.html.twig', [
            'asso' => $asso,
            'form' => $form,
        ]);
    }

    #[Route('/asso/{id}', name: 'app_admin_asso_delete', methods: ['POST'])]
    public function deleteAsso(Request $request, Asso $asso, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $asso->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($asso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_asso_index', [], Response::HTTP_SEE_OTHER);
    }

    //crud administration sections//

    #[Route('/sections', name: 'app_admin_sections_index', methods: ['GET'])]
    public function indexSections(SectionsRepository $sectionsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('administration/adminSections.html.twig', [
            'sections' => $sectionsRepository->findAll(),
        ]);
    }

    #[Route('/sections/new', name: 'app_admin_sections_new', methods: ['GET', 'POST'])]
    public function newSections(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $section = new Sections();
        $form = $this->createForm(SectionsType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($section);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sections_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sections/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/sections/{id}/edit', name: 'app_admin_sections_edit', methods: ['GET', 'POST'])]
    public function editSections(Request $request, Sections $section, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SectionsType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sections_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sections/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/sections/{id}', name: 'app_sections_delete', methods: ['POST'])]
    public function delete(Request $request, Sections $section, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($section);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sections_index', [], Response::HTTP_SEE_OTHER);
    }

    //crud administration Members//

    #[Route('/members', name: 'app_admin_members_index', methods: ['GET'])]
    public function indexMembers(MembersRepository $membersRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('administration/adminMembers.html.twig', [
            'members' => $membersRepository->findAll(),
        ]);
    }

    #[Route('/members/new', name: 'app_admin_members_new', methods: ['GET', 'POST'])]
    public function newMembers(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $member = new Members();
        $form = $this->createForm(MembersType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_members_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('members/new.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/members/{id}/edit', name: 'app_admin_members_edit', methods: ['GET', 'POST'])]
    public function editMembers(Request $request, Members $member, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembersType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_members_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('members/edit.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/members/{id}', name: 'app_admin_members_delete', methods: ['POST'])]
    public function deleteMembers(Request $request, Members $member, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_members_index', [], Response::HTTP_SEE_OTHER);
    }

    //crud administration Teams//

    #[Route('/teams', name: 'app_adminteams_index', methods: ['GET'])]
    public function indexTeams(TeamsRepository $teamsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('administration/adminTeams.html.twig', [
            'teams' => $teamsRepository->findAll(),
        ]);
    }

    #[Route('/teams/new', name: 'app_admin_teams_new', methods: ['GET', 'POST'])]
    public function newTeams(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $team = new Teams();
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/teams/{id}/edit', name: 'app_admin_teams_edit', methods: ['GET', 'POST'])]
    public function editTeams(Request $request, Teams $team, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/teams/{id}', name: 'app_teams_delete', methods: ['POST'])]
    public function deleteTeams(Request $request, Teams $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_teams_index', [], Response::HTTP_SEE_OTHER);
    }
}
