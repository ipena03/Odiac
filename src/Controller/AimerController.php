<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AimerController extends AbstractController
{

    #[Route('/aimer/{id}', name: 'app_aimer')]
    public function aimer(Produit $produit, EntityManagerInterface $em): Response
    {

        if ($this->getUser()->getAimer()->contains($produit)) {
            $this->getUser()->removeAimer($produit);
            $this->addFlash('notice', $produit->getNom() . 'supprimer des favoris');
        } else {
            $this->getUser()->addAimer($produit);
            $this->addFlash('notice', $produit->getNom() . 'ajouté aux favoris');
        }

        $em->persist($this->getUser());
        $em->flush();

        return $this->redirectToRoute('app_hauts');
    }
}
