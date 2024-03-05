<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeStudentController extends AbstractController
{
    #[Route('/home/student', name: 'app_home_student')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user->getEleve() === null) {
            return $this->redirectToRoute('app_home_parents');
        } 
        return $this->render('home_student/index.html.twig', [
            'controller_name' => 'HomeStudentController',
        ]);
    }
}
