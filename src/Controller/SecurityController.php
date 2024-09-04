<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Form\ResetPasswordFormType;
use App\Form\ForgotPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmailVerifyRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgot-password', name: 'forgot.password')]
    public function forgotenPassword(
        Request $request,
        EmailVerifyRepository $emailVerifyRepository,
        MailerInterface $mailerInterface,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $verify = $emailVerifyRepository->findOneByEmail($form->get('email')->getData());

            //if user existe
            if ($verify) {

                // on genère le de vérification
                $code = rand(11111, 99999);
                // on génère le temps
                $time = (time() + (60 * 60));

                $verify->setCode($code)
                    ->setTime($time);
                $entityManagerInterface->flush();

                try {

                    $mail = (new TemplatedEmail())
                        ->to($verify->getEmail())
                        ->from('hoberenakbambino@gmail.com')

                        ->subject('Please Confirm your Email')
                        ->htmlTemplate('emails/forgot_email.html.twig')

                        ->context(['code' => $code]);
                    $mailerInterface->send($mail);
                } catch (\Exception $e) {

                    $this->addFlash('danger', "impossible d'envoyer votre email");
                    return $this->redirectToRoute('forgot.password');
                }

                $this->addFlash('success', 'vous avez un code de confirmation dans boite mail');
                return $this->redirectToRoute('reset.password');
            } else {
                $this->addFlash('danger', "Incorrect email");
                return $this->redirectToRoute('forgot.password');
            }
        }

        return $this->render('security/forgot_password.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/reset-password', name: 'reset.password')]
    public function resetPassword(
        Request $request,
        EmailVerifyRepository $emailVerifyRepository,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $verify = $emailVerifyRepository->findOneByEmail($form->get('email')->getData());
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            if ($verify && $user) {

                if ($verify->getTime() > time()) {
                    if ($verify->getCode() === $form->get('code')->getData()) {


                        $user->setPassword(
                            $hasher->hashPassword(
                                $user,
                                $form->get('password')->getData()

                            )
                        );
                        $em->flush();

                        $this->addFlash('success', "Mot de passe changer avec succès");
                        return $this->redirectToRoute('app_login');
                    } else {
                        $this->addFlash('danger', "wrong code ");
                        return $this->redirectToRoute('reset.password');
                    }
                } else {
                    $this->addFlash('danger', "le code est expireé");
                    return $this->redirectToRoute('reset.password');
                }
            } else {
                $this->addFlash('danger', "un probleme est survenue");
                return $this->redirectToRoute('reset.password');
            }
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form
        ]);
    }
}
