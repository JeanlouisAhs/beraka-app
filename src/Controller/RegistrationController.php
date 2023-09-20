<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\MailService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        MailService $mailService,
        TokenGeneratorInterface $tokenGeneratorInterface
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //Token
            $tokenRegistration = $tokenGeneratorInterface->generateToken();

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //User TOKEN
            $user->setTokenRegistration($tokenRegistration);

            $entityManager->persist($user);
            $entityManager->flush();


            // Mail
            $mailService->send(
                $user->getEmail(),
                'Activate your account',
                'registration_confirmation.html.twig',
                [
                   'user' => $user,
                    'token' => $tokenRegistration,
                    'lifetimeToken'=> $user->getTokenRegistrationLifeTime()->format('Y-m-d H:i:s')
                    
                ]
            );

            $this->addFlash('success', 'Your account has been created successfully, Check your email to activate it.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // Create account_verify route
    #[Route('/verify/{token}/{id<\d+>}', name: 'account_verify', methods: ['GET'])]
    public function verify (string $token,User $user, EntityManagerInterface $entityManager): Response{
        if ($user->getTokenRegistration() !=$token ){
            throw new AccessDeniedException();
        }

        if ($user->getTokenRegistration() ==null){
            throw new AccessDeniedException();
        }

        if(new DateTime('now') > $user->getTokenRegistrationLifeTime()){
            throw new AccessDeniedException();
        }
        $user->setIsVerified(true);
        $user->setTokenRegistration(null);
        $entityManager->flush();

        $this->addFlash('success', 'Your account has been activated successfully.');

        return $this->redirectToRoute('app_login');
    }
}
