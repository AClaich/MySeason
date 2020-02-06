<?php

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends Controller
{
    /**
     * @Route("/ajout", name="ajout")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $food= new Food();
        $foodForm= $this->createForm(DetailsType::class, $food);

        $foodForm->handleRequest($request);
        if($foodForm->isSubmitted() && $foodForm->isValid()){
            $entityManager->persist($food);
            $entityManager->flush();
            $this->addFlash('success', 'Element ajouté !');
            return $this->redirectToRoute('layout');
        }

        return $this->render('admin/ajout.html.twig', [
            'controller_name' => 'AdminController',
            'foddFormView' => $foodForm->createView()
        ]);
    }
}
