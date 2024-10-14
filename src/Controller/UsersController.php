<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/{id}/set/role', name: 'app_role_set', requirements: ['id' => Requirement::DIGITS])]
    public function setRole(EntityManagerInterface $entityManagerInterface, User $user): RedirectResponse
    {
        $user->setRoles(["ROLE_ADMIN"]);
        $entityManagerInterface->flush();

        $this->addFlash('success', "role set successfully");
        return $this->redirectToRoute('app_all_user');
    }

    #[Route('/{id}/remove/role', name: 'app_role_remove', requirements: ['id' => Requirement::DIGITS])]
    public function removeRole(EntityManagerInterface $entityManagerInterface, User $user): RedirectResponse
    {
        $user->setRoles([]);
        $entityManagerInterface->flush();

        $this->addFlash('danger', "role removed successfully");
        return $this->redirectToRoute('app_all_user');
    }

}