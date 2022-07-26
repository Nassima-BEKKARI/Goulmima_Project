<?php

namespace App\Controller;

use LogicException;
use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function passerAdmin(UserRepository $repo, Request $request, $id)
    {
        $secret="123456";

        $form= $this->createForm(AdminType::class);
        $form->handleRequest($request);

        $user =$repo->find($id);

        if(!$user){
            $this->addFlash("error", "Aucun utilisateur trouvé avec l'id $id");
            return $this->redirectToRoute("app_home");
        }
        if($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('secret')->getData() == $secret)
            {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $this->addFlash("error", "Vous n'êtes pas autorisés à effectuer cette action, veuillez contacter l'administrateur du site");
                return $this->redirectToRoute("app_home");
            }
            $repo->add($user,1);
            $this->addFlash("success", "Vous êtes désormais admin, veuillez vous reconnecter pour profiter de vos privilèges");
            return $this->redirectToRoute("app_login");
        }
        return $this->render("security/passer_admin.html.twig", [
            "user" => $user,
            "formAdmin" => $form->createView()
        ]);
    }
}
