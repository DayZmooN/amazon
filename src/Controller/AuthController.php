<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthController extends AbstractController
{
    private HttpClientInterface $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    #[Route('/login', name: 'login')]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $response = $this->client->request('POST', 'http://127.0.0.1:8000/api/login_check', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);

            if ($response->getStatusCode() === Response::HTTP_OK) {
                $data = $response->toArray();
                $token = $data['token'] ?? null;

                if ($token) {
                    // Stocker le token dans la session ou autre
                    $this->addFlash('success', 'Login successful!');
                    return $this->redirectToRoute('home');
                } else {
                    $this->addFlash('error', 'Login failed!');
                }
            } else {
                $this->addFlash('error', 'Login request failed!');
            }
        }

        return $this->render('auth/index.html.twig');
    }

    #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]
    public function loginCheck()
    {
        // Cette méthode sera interceptée par le LexikJWTAuthenticationBundle
        // Vous n'avez pas besoin d'implémenter la logique ici
    }

    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me()
    {
        $user = $this->getUser();
        return new JsonResponse([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return new JsonResponse(['message' => 'Welcome to the home page!']);
    }
}
