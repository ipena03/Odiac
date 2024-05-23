<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(ProduitRepository $produitRepository, Request $request): Response
    {

        $query = $request->query->get('q');
        $Produit = $produitRepository->findBySearchQuery($query);
        return $this->render('recherche/index.html.twig', [
            'produit' => $Produit,
            'q' => $query

        ]);
    }
}
