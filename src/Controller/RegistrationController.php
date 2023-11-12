<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
 
#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: 'post')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {   
        // Get the username and password of the user to create
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent());
        $username = $decoded->username;
        $plaintextPassword = $decoded->password;
           
        // Hash the password and create the user
        $user = new User();        
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setUsername($username);
        $em->persist($user);
        $em->flush();
   
        return $this->json(['message' => 'Api User registered Successfully']);
    }
}