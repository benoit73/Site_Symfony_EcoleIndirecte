<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
Use App\Entity\Eleve;
Use App\Entity\Parents;
use App\Repository\EleveRepository;
use App\Repository\ParentsRepository;
use Symfony\Component\Form\FormError;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private ParentsRepository $parentsRepository;
    private EleveRepository $eleveRepository;

    public function __construct(EmailVerifier $emailVerifier, EleveRepository $eleveRepository, ParentsRepository $parentsRepository)
    {
        $this->emailVerifier = $emailVerifier;
        $this->eleveRepository = $eleveRepository;
        $this->parentsRepository = $parentsRepository;
    }

    public function isEmailExisting($email) : string
    {
        $eleve = $this->eleveRepository->findOneBy(['mail_eleve' => $email]);
        $parent = $this->parentsRepository->findOneBy(['email' => $email]);
    
        if ($eleve !== null)
        {
            return "eleve";
        }        
        
        if ($parent !== null)
        {
            return "parent";
        }
    
        return false;
    }
    





    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');
        }
    
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if email exists
            if (!$this->isEmailExisting($user->getEmail())) {
                // Add an error to the form
                $form->addError(new FormError('Cet email n\'existe pas.'));
                // Render the registration form with error
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }
    
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            if ($this->isEmailExisting($user->getEmail()) == "eleve") 
            {
                $eleveRepository = $entityManager->getRepository(Eleve::class);
                $eleve = $eleveRepository->findOneBy(['mail_eleve' => $user->getEmail()]);
                $user->setEleve($eleve);
            }

            if ($this->isEmailExisting($user->getEmail()) == "parent") 
            {
                $parentsRepository = $entityManager->getRepository(Parents::class);
                $parents = $parentsRepository->findOneBy(['email' => $user->getEmail()]);
                $user->setParents($parents);
            }


            $entityManager->persist($user);
            $entityManager->flush();
    
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('benoit.mathiez@saintmichelannecy.fr', 'Ecole Indirecte Bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
    
            return $this->redirectToRoute('app_home');
        }
    
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
