<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Category;
use App\Form\ProjetType;
use App\Form\CategoryType;
use App\Repository\ProjetRepository;
use App\Repository\CategoryRepository;
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
     * @Route("/createCategory", name="create_category")
     */
    public function category_create(Request $request, EntityManagerInterface $em){
        $category= new Category();
        $form= $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($category);
            $em->flush();
            return$this->redirectToRoute('app_home');
        }
        return $this->render('projet/category.html.twig', ['form'=>$form->createView()]);

    }
    /**
     * @Route("/createProjet", name="create_projet")
     */
    
    public function create(Request $request, EntityManagerInterface $em,CategoryRepository $repo)
    {
        $categorie= new Category();
        $projet= new Projet();
        $form= $this->createForm(ProjetType::class,$projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($projet);
            $em->flush();

            return$this->redirectToRoute('app_home');

        }

        return $this->render('projet/createProjet.html.twig', ['form'=>$form->createView(),'$categorie'=>$repo->findAll()]);

    }
}
