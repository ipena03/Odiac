<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Panier;
use App\Entity\Inserer;
use App\Entity\Produit;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;






class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(ProduitRepository $pr,): Response
    {
        $produit = $pr->findAll();
        $panier = $this->getUser()->getPanier()->getInserers();
        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'produit' => $produit,
        ]);
    }


    #[Route('/private-ajout-panier-produit/{id}', name:'app_ajout_panier_produit')]
    public function ajoutPanierProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        if($produit!=null){
            if($this->getUser()->getPanier()==null){
                $panier = new Panier();
            } else {
                $panier = $this->getUser()->getPanier();
            }
            $inserer = new Inserer();
            $inserer->setPanier($panier);
            $inserer->setProduit($produit);
            $inserer->setQuantite(1);
            $panier->addInserer($inserer);
            $this->getUser()->setPanier($panier);
            $em->persist($inserer);
            $em->persist($panier);
            $em->persist($this->getUser());
            $em->flush();
            $this->addFlash('notice', 'Produit Ajouté');
        }
        return $this->redirectToRoute('app_hauts');
    }


    #[Route('/private-supprimer-panier-produit/{id}', name:'app_supprimer_panier_produit')]
    public function supprimerPanierProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        foreach ($this->getUser()->getPanier()->getInserers() as $i){
            if($this->getUser()->getPanier()->getInserers()->contains($i)){
                if($i->getProduit()==$produit){
                    $this->getUser()->getPanier()->removeInserer($i);
                    $this->addFlash('notice', 'Produit Supprimé');
                }
            }
        }
            $em->persist($this->getUser());
            $em->flush();
            return $this->redirectToRoute('app_hauts');
        }
    }

    



