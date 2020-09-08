<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{

    /**
     * @Route("/projet/{id<[0-9]+>}", name="projetId")
     */

     public function show(ProjetRepository $repo, $id)
     {
     return $this->render('projet/show.html.twig',['projets'=>$repo->find($id)]);

     }
    /**
     * @Route("/projet", name="projet")
     */

     public function index(ProjetRepository $repo)
     {

        return $this->render("projet/index.html.twig",['projet'=>$repo->findAll()]);

     }
    /**
     * @Route("/createProjet", name="create_projet")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $projet= new Projet();
        $form= $this->createForm(ProjetType::class,$projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($projet);
            $em->flush();

            return$this->redirectToRoute('app_home');
        }

        return $this->render('projet/createProjet.html.twig', ['form'=>$form->createView()]);
    }
}
