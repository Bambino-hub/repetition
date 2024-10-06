<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Entity\WorkSpace;
use App\Form\WorkSpaceType;
use App\Repository\ProgrammeRepository;
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
        $programme = new Programme;

        $form = $this->createForm(WorkSpaceType::class, $wokspace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            if ($user) {
                $wokspace->setUser($user);
                $programme->setUser($user);

                //on recupère les jours 
                $days = $wokspace->getDays();

                // On compte le nombre total de jour 
                $dayNumber = count($days);

                // on boucle pour recupérer le nom de jour
                for ($i = 0; $i < $dayNumber; $i++) {
                    $value = $days[$i];
                    $day[] = $value->getName();
                }
                $programme->setDays($day);

                // on recupère les matières
                $matters = $wokspace->getMatters();

                // On compte le nombre total de matières 
                $matterNumber = count($matters);

                // on boucle pour recupérer le nom de la matière
                for ($i = 0; $i < $matterNumber; $i++) {
                    $value = $matters[$i];
                    $matter[] = $value->getName();
                }
                $programme->setMatter($matter);

                // on recupère les horaires de travail
                $times = $wokspace->getTimeTables();

                // On compte le nombre total d'horaire
                $timeNumber = count($times);

                // on boucle pour recupérer le nom de l'horaire
                for ($i = 0; $i < $timeNumber; $i++) {
                    $value = $times[$i];
                    $time[] = $value->getName();
                }
                $programme->setTimeTable($time);

                // on recupère niveau de l'élève
                $level = $wokspace->getLevel()->getName();
                $programme->setLevel($level);

                $entityManagerInterface->persist($programme);
                $entityManagerInterface->flush();

                $this->addFlash('success', "Nous avons bien recueillit votre emploi du temps");
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
        Request $request,
        ProgrammeRepository $programmeRepository
    ): Response {

        // on recupère la page courrante s'il n'y a pas on met par défaut 1
        $page = $request->query->getInt('page', 1);
        $programmes = $programmeRepository->pagination($page);

        return $this->render('work_space/work_all.html.twig', [
            'programmes' => $programmes
        ]);
    }
}