<?php

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $entityManager, Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $response = new Response(
                '',
                Response::HTTP_OK,
                ['content-type' => 'text/html']
            );

            $response->headers->setCookie(new Cookie('lastUsername', $this->getUser()->getUsername()));

            $response->prepare($request);
            $response->send();
        }
        $foodRepository = $entityManager->getRepository(Food::class);

        $foods = $foodRepository->find5Random();

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
        throw $this->createNotFoundException('Cet élément n\'existe pas');
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
    {
        //get the login error if there is one

        $error = $authenticationUtils->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

    }

    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(EntityManagerInterface $entityManager)
    {
        $foodRepository = $entityManager->getRepository(Food::class);
        $foods = $foodRepository->findAll();
        return $this->render('main/catalogue.html.twig', compact('foods'));
    }
}
