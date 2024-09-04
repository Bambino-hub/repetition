<?php

namespace App\Controller;

use App\Entity\WorkSpace;
use App\Form\WorkSpaceType;
use App\Repository\WorkSpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkSpaceController extends AbstractController
{
    #[Route('/profile/work/space', name: 'app_work_space')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $wokspace = new WorkSpace();
        $form = $this->createForm(WorkSpaceType::class, $wokspace);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            if ($user) {
                $wokspace->setUser($user);

                $entityManagerInterface->persist($wokspace);
                $entityManagerInterface->flush();

                $this->addFlash('success', "Nous avons bien recueillit votre em ploi du temps");
                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('danger', "Veillez vous connecter pour continuer");
                return $this->redirectToRoute('app_login');
            }
        }


        return $this->render('work_space/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/work/space/all', name: 'app_work_space_all')]
    #[IsGranted('ROLE_ADMIN')]
    public function getAllWorkSpace(
        WorkSpaceRepository $workSpaceRepository
    ): Response {

        return $this->render('work_space/work_all.html.twig', [
            'workspaces' => $workSpaceRepository->findAll()
        ]);
    }
}