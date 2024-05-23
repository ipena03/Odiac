<?php

namespace App\Controller;

use App\Entity\Inserer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;

class ListingPanierController extends AbstractController
{
    #[Route('/listing_panier', name: 'app_listing_panier')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $panier = $this->getUser()->getPanier()->getInserers();
        $produits=$produitRepository->findAll();
        return $this->render('listing_panier/listing_panier.html.twig', [
            'panier'=> $panier,
            'produits'=>$produits
        ]);
    }
}
