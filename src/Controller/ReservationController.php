<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    public function book(Request $request, ReservationRepository $repo)
    {
        $reservation = new Reservation();
        $form = $this->createform(ReservationType::class, $reservation);
        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $repo->add($reservation,1);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('reservation/formulaireReservation.html.twig', [
            'formReservation' => $form->createView()
        ]);
    }
}
