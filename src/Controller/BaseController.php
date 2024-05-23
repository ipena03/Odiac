<?php
namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ContactType;
use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Aimer;




class BaseController extends AbstractController
{


    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/acceuil.html.twig', [

        ]);
    }





    #[Route('/private-acceuil', name: 'app_accueil_perso')]
    public function acceuil_perso(UserRepository $userRepository): Response
    {
        return $this->render('base/acceuil_perso.html.twig', [

        ]);
    }







    #[Route('/mod-produit', name: 'app_produit')]
    public function produit(Request $request, EntityManagerInterface $em): Response
    {

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $produit->setDateEnvoi(new \Datetime());
                $em->persist($produit);
                $em->flush();
                $this->addFlash('notice', 'Produit envoyé');
                return $this->redirectToRoute('app_produit');

            }
        }

        return $this->render('base/produit.html.twig', [
            'form' => $form->createView()


        ]);
    }



    #[Route('/hauts', name: 'app_hauts')]
    public function hauts(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        return $this->render('base/hauts.html.twig', [
            'produits' => $produits
        ]);
    }



    #[Route('/page_produit/{id}', name: 'app_page_produit')]
    public function page_produit(Produit $produit): Response
    {

        return $this->render('base/page_produit.html.twig', [
            'produit' => $produit
        ]);
    }















    #[Route('/nous_contacter', name: 'app_nous_contacter')]
    public function nous_contacter(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('app_nous_contacter');


            }
        }

        return $this->render('base/nous_contacter.html.twig', [
            'form' => $form->createView()
        ]);
    }



    #[Route('/mentions_legales', name: 'app_mentions_legales')]
    public function mentions_legales(): Response
    {
        return $this->render('base/mentions_legales.html.twig', [

        ]);
    }




    #[Route('/a_propos', name: 'app_a_propos')]
    public function a_propos(): Response
    {
        return $this->render('base/a_propos.html.twig', [

        ]);
    }





    #[Route('/politque_de_confidentialite', name: 'app_politque_de_confidentialite')]
    public function politque_de_confidentialite(): Response
    {
        return $this->render('base/politque_de_confidentialite.html.twig', [

        ]);
    }







}
