<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\AjoutType;
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
        $foodForm= $this->createForm(AjoutType::class, $food);

        $foodForm->handleRequest($request);
        if($foodForm->isSubmitted() && $foodForm->isValid()){
            $fileName= $foodForm['name']->getData();

            $file = $foodForm['picture']->getData();
            $file->move('img', $fileName);

            $entityManager->persist($food);
            $entityManager->flush();
            $this->addFlash('success', 'Element ajouté !');
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/ajout.html.twig', [
            'controller_name' => 'AdminController',
            'foodFormView' => $foodForm->createView()
        ]);
    }
}
