<?php

namespace App\Controller;

use App\Entity\TimeTable;
use App\Form\TimeTableType;
use App\Repository\TimeTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/repetion/time/table')]
#[IsGranted('ROLE_ADMIN')]
final class TimeTableController extends AbstractController
{
    #[Route(name: 'app_time_table_index', methods: ['GET'])]
    public function index(TimeTableRepository $timeTableRepository): Response
    {
        return $this->render('time_table/index.html.twig', [
            'time_tables' => $timeTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_time_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $timeTable = new TimeTable();
        $form = $this->createForm(TimeTableType::class, $timeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($timeTable);
            $entityManager->flush();

            return $this->redirectToRoute('app_time_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('time_table/new.html.twig', [
            'time_table' => $timeTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_time_table_show', methods: ['GET'])]
    public function show(TimeTable $timeTable): Response
    {
        return $this->render('time_table/show.html.twig', [
            'time_table' => $timeTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_time_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TimeTable $timeTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TimeTableType::class, $timeTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_time_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('time_table/edit.html.twig', [
            'time_table' => $timeTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_time_table_delete', methods: ['POST'])]
    public function delete(Request $request, TimeTable $timeTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $timeTable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($timeTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_time_table_index', [], Response::HTTP_SEE_OTHER);
    }
}