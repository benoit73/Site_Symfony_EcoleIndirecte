<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\EntityManagerInterface;

class HomeStudentController extends AbstractController
{
    #[Route('/home/student', name: 'app_home_student')]

        public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        if ($user->getEleve() === null) {
            return $this->redirectToRoute('app_home_parents');
        } 

        $eleve = $user->getEleve();
        $absences = $eleve->getAbsences();
        $nbAbsences = count($absences);
        $absencesJustifiees = new ArrayCollection();

        foreach($absences as $absence)
        {
            if ($absence->isJustifiee()){
                $absencesJustifiees->add($absence);
            }
        }
        $nbAbsencesJustifiees = count($absencesJustifiees);
        $nbAbsencesNonJustifiees = $nbAbsences - $nbAbsencesJustifiees;


        $calendrierRepository = $entityManager->getRepository('App\Entity\Calendrier');

        $filtre = $request->query->get('sort'); // 'date' est la valeur par défaut, ajustez selon vos besoins

        switch ($filtre) {
            case 'date':
                $absencesArray = $absences->toArray();
                usort($absencesArray, function ($a, $b) {
                    $semaineA = $a->getCour()->getSemaine();
                    $semaineB = $b->getCour()->getSemaine();
            
                    // Compare les semaines
                    if ($semaineA !== $semaineB) {
                        return $semaineA - $semaineB;
                    }
            
                    // Si les semaines sont égales, compare les jours
                    $jourA = $a->getCour()->getJour();
                    $jourB = $b->getCour()->getJour();
            
                    if ($jourA !== $jourB) {
                        return $jourA - $jourB;
                    }
            
                    // Si les jours sont égaux, compare les heures
                    $heureA = $a->getCour()->getDebut();
                    $heureB = $b->getCour()->getDebut();
            
                    return $heureA - $heureB;
                });
            
                $absences = new ArrayCollection($absencesArray);
                break;  
            case 'duree':
                $absencesArray = $absences->toArray();
                usort($absencesArray, function ($a, $b) {
                    return $a->getCour()->getDuree() - $b->getCour()->getDuree();
                });
    
                $absences = new ArrayCollection($absencesArray);
            break;

            case 'justifiee':
                $absencesArray = $absences->toArray();
                usort($absencesArray, function ($a, $b) {
                    return $a->isJustifiee() - $b->isJustifiee();
                });
                $absences = new ArrayCollection($absencesArray);
                break;
            
            case 'professeur':
                $absencesArray = $absences->toArray();
                usort($absencesArray, function ($a, $b) {
                    return strcmp(
                        $a->getCour()->getEnseignant()->getId(),
                        $b->getCour()->getEnseignant()->getId()
                    );
                });
                $absences = new ArrayCollection($absencesArray);
                break;
        
            case 'matiere':
                $absencesArray = $absences->toArray();
                usort($absencesArray, function ($a, $b) {
                    return strcmp(
                        $a->getCour()->getEnseignant()->getMatiere()->getNomMatiere(),
                        $b->getCour()->getEnseignant()->getMatiere()->getNomMatiere()
                    );
                });
                $absences = new ArrayCollection($absencesArray);
                break;
        }

        return $this->render('home_student/index.html.twig', [
            'filtre' => $filtre,
            'nbAbsences' => $nbAbsences,
            'absences' => $absences,
            'controller_name' => 'HomeParentController',
            'calendrierRepository' => $calendrierRepository,
            'nbAbsencesJustifiees' => $nbAbsencesJustifiees,
            'nbAbsencesNonJustifiees' => $nbAbsencesNonJustifiees,
        ]);
    }
}
