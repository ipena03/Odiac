<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;

class ListingFavorisController extends AbstractController
{
    #[Route('/listing_favoris', name: 'app_listing_favoris')]
    public function index(): Response
    {
        
        $favoris = $this->getUser()->getAimer();
        return $this->render('listing_favoris/listing_favoris.html.twig', [
            'favoris'=>$favoris
            
            
        ]);
    }
}
