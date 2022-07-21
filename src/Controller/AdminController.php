<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function listeChambres(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('admin/chambres.html.twig', [
            'chambres'=> $chambres
        ]);
    }

    public function addChambre(Request $request)
    {
        $chambre = new Chambre;
        $form = $this->createform(ChambreType::class, $chambre);
        $form->handlerequest($request);
         if($form->isSubmitted() && $form->isValid())
        {
            $repo->add($chambre,1);
            return $this->redirectToRoute("app_home");
        }
            return $this->render("admin/formulaireChambre.html.twig",[
            "formChambre"=> $form->createView()]);
    }
}
