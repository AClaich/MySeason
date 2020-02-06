<?php

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $entityManager)
    {
        $foodRepository = $entityManager->getRepository(Food::class);

        $foods = $foodRepository->find5Random();
        dump($foods);

        return $this->render('main/layout.html.twig', compact('foods'));
    }

    /**
     * @Route("/{id}", name="detail", requirements={"id" : "\d+"})
     */
    public function detail(EntityManagerInterface $entityManager, $id)
    {
        $foodRepository = $entityManager->getRepository(Food::class);
        $food = $foodRepository->find($id);

        if (empty($food)) {
            throw $this->createNotFoundException('Cet élément n\'existe pas');
        } else {
            return $this->render('main/details.html.twig', compact('food'));
        }
        return $this->createNotFoundException('Cet élément n\'existe pas');
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        //get the login error if there is one

        $error = $authenticationUtils->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,]);
    }

}
