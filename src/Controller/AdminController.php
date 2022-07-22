<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\PhotoRepository;
use App\Repository\ChambreRepository;
use Doctrine\Persistence\ManagerRegistry;
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
            return $this->redirectToRoute("app_admin_allChambres
            
            ");
        }
            return $this->render("admin/formulaireChambre.html.twig",[
            "formChambre"=> $form->createView()]);
    }

    public function updateChambre($id, ManagerRegistry $doctrine, ChambreRepository $repo, Request $request, SluggerInterface $slugger)
    {
        $chambre = $repo->find($id);
        $form = $this->createform(ChambreType::class, $chambre);
        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('photos')->getData())
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
        }
            $manager = $doctrine->getManager();
            $manager->persist($chambre);
            $manager->flush();

            return $this->redirectToRoute('app_admin_allChambres');
    }
        return $this->render('admin/formulaireChambre.html.twig', [
            'formChambre' => $form->createView()
        ]);
        
    }

    public function deleteChambre(ChambreRepository $repo, $id)
    {
        $chambre = $repo->find($id);
        $repo->remove($chambre, 1);

        return $this->redirectToRoute("app_admin_allChambres");
    }

    public function allChambres(ChambreRepository $repo, )
    {
        $chambres = $repo->findAll();
        // dd($chambres);
        return $this->render('admin/chambres.html.twig', [
        'chambres'=> $chambres,
        ]);

    }

    public function deletePhoto(Photo $photo, Request $request)
    {

    }
}
