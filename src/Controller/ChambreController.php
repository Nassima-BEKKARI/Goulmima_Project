<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChambreController extends AbstractController
{
    public function allChambres(ChambreRepository $repo)
    {
        $chambres = $repo->findAll();
        return $this->render('chambre/chambresListe.html.twig', [
        'chambres'=> $chambres
        ]);
    }

    public function select($id, ChambreRepository $repo)
    {
        $chambre = $repo->find($id);

        return $this->render('chambre/chambre.html.twig', [
            'chambre'=>$chambre
        ]);
    }
}
