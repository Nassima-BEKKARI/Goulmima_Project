<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class ReservationController extends AbstractController
{
    public function book(Request $request, ReservationRepository $repo, ManagerRegistry $doctrine, SessionInterface $session)
    {
        $reservation = new Reservation();
        $form = $this->createform(ReservationType::class, $reservation);
        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $idChambre = $request->get("reservation")['Chambre'];
            $chambre = $doctrine->getRepository(Chambre::class)->find($idChambre);
            $reservation->addChambre($chambre);

            // dd($reservation);
            $repo->add($reservation,1);
            
            $session->set('reservation', $reservation);
            return $this->redirectToRoute('app_panier');
        }
        return $this->render('reservation/formulaireReservation.html.twig', [
            'formReservation' => $form->createView()
        ]);
    }
}
