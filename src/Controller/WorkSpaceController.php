<?php

namespace App\Controller;

use App\Entity\WorkSpace;
use App\Form\WorkSpaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkSpaceController extends AbstractController
{
    #[Route('/work/space', name: 'app_work_space')]
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
}
