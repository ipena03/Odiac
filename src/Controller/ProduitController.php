<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Form\ModifierProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SupprimerProduitType;


class ProduitController extends AbstractController
{
   #[Route('/mod-liste_produits', name: 'app_liste_produits')]
   public function listeProduits(
      Request $request,
      ProduitRepository $produitRepository,
      EntityManagerInterface $em
   ): Response {
      $produits = $produitRepository->findAll();

      $form = $this->createForm(SupprimerProduitType::class, null, [
         'produits' => $produits
      ]);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $selectedproduits = $form->get('produits')->getData();
         foreach ($selectedproduits as $produit) {
            $em->remove($produit);
         }
         $em->flush();
         $this->addFlash('notice', 'Produit supprimées avec succès');
         return $this->redirectToRoute('app_liste_produits');
      }


      return $this->render('produit/liste_produits.html.twig', [
         'produit' => $produits,

         'form' => $form->createView(),

      ]);
   }



   #[Route('/mod-modifier_produit/{id}', name: 'app_modifier_produit')]

   public function modifierProduit(
      Request $request,
      Produit
      $produit,
      EntityManagerInterface $em
   ): Response {

      $form = $this->createForm(ModifierProduitType::class, $produit);
      if ($request->isMethod('POST')) {
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('notice', 'produit modifiée');
            return $this->redirectToRoute('app_liste_produits');
         }
      }
      return $this->render('produit/modifier_produit.html.twig', [
         'form' => $form->createView()


      ]);
   }


   #[Route('/mod-supprimer_produit/{id}', name: 'app_supprimer_produit')]
   public function supprimerProduit(
      Request $request,
      Produit
      $produit,
      EntityManagerInterface $em
   ): Response {
      if ($produit != null) {
         $em->remove($produit);
         $em->flush();
         $this->addFlash('notice', 'Produit supprimée');
      }
      return $this->redirectToRoute('app_liste_produits');
   }

}
