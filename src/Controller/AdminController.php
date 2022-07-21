<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    public function listeChambres(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('admin/chambres.html.twig', [
            'chambres'=> $chambres
        ]);
    }

    public function addChambre(Request $request, ChambreRepository $repo, SluggerInterface $slugger)
    {
        $chambre = new Chambre;
        $form = $this->createform(ChambreType::class, $chambre);
        $form->handlerequest($request);
         if($form->isSubmitted() && $form->isValid())
        {
            $images = $form->get('photos')->getData();

            foreach($images as $image){
            $imageName = $slugger->slug($chambre->getNom()) . uniqid() . '.' . $image->guessExtension();
            
            try{
                $image->move($this->getParameter('photos_chambres'), $imageName);
            } catch (FileException $error){

            }
            $photo = new Photo();
            $photo->setNom($imageName);
            $chambre->addPhoto($photo);
            }
            $repo->add($chambre,1);
            return $this->redirectToRoute("app_home");
        }
            return $this->render("admin/formulaireChambre.html.twig",[
            "formChambre"=> $form->createView()]);
    }
}
