<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    public function panier(ReservationRepository $repo, SessionInterface $session)
    {
        $reservation = $session->get('reservation');
        $chambre = $reservation->getChambre();
        // $dateEntree = $reservation->find($reservation->$id);
        // $date1= $dateEntree-> getDateArrivee();
        // $dateDepart = $repo->find($id);
        // $date2= $dateDepart->getDateDepart();

        // $nbdays = $date2->diff($date1)->days;

        // $chambre = $repo->find($id);
        //dd($reservation->getDateDepart());
        $nbrJour = $reservation->getDateDepart()->diff($reservation->getDateArrivee());
        $nbrJour = intval($nbrJour->format("%d"));
        $prixTotal = $chambre[0]->getPrix()*$nbrJour;
        $nomChambre = $chambre[0]->getNom();
        return $this->render('panier/index.html.twig', [
            'nbrJour' => $nbrJour,
            'prixTotal' => $prixTotal,
            'nomChambre' => $nomChambre,
        ]);
    }
}
