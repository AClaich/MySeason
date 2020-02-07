<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/user", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/course", name="course")
     */
    public function liste_course(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->render('user/course.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }
}
