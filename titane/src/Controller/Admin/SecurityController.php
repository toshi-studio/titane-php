<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Handles authentication for the admin interface.
 * Provides login and logout functionality for admin users.
 */
class SecurityController extends AbstractController
{
    /**
     * Displays the admin login form.
     * 
     * @param AuthenticationUtils $authenticationUtils Service to retrieve authentication errors
     * @return Response The rendered login form
     */
    #[Route('/admin/login', name: 'easyadmin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'translation_domain' => 'admin',
            'page_title' => 'Titane Admin Login',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('admin'),
            'username_label' => 'Your email',
            'password_label' => 'Your password',
            'sign_in_label' => 'Log in',
            'forgot_password_enabled' => false,
            'remember_me_enabled' => true,
            'remember_me_label' => 'Remember me',
        ]);
    }

    /**
     * Logout route for admin users.
     * This method is intercepted by the security system and never executed.
     * 
     * @throws \LogicException
     */
    #[Route('/admin/logout', name: 'easyadmin_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}