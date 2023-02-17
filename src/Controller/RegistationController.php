<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistationController extends AbstractController
{
    /**
     * @Route("/register", name="signIn_page")
     */
    public function register(Request $req, UserPasswordHasherInterface $userPasswordHasher,
     EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            //encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user, $form->get('password')->getData()
                )
                );
                $user->setRoles(['ROLE_USER']);

                $entityManager->persist($user);
                $entityManager->flush();
                //  do anything eslse you nedd here, like send and email

                return $this->redirectToRoute('logout_page');
        }
            return $this->render('registation/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="logout_page")
     */
    public function logOutAction(): Response
    {
        return $this->render('registation/login.html.twig');
    }
}
