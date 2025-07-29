<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Main dashboard controller for the Titane admin interface.
 * Provides the main navigation and dashboard configuration.
 */
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    /**
     * Main dashboard route that displays the admin homepage.
     * 
     * @return Response The rendered dashboard view
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    /**
     * Configure the dashboard settings including title, favicon, and other UI elements.
     * 
     * @return Dashboard The configured dashboard object
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Titane Admin')
            ->setFaviconPath('favicon.ico')
            ->setTranslationDomain('admin')
            ->generateRelativeUrls()
            ->setLocales(['en', 'fr'])
            ->setTextDirection('ltr')
            ->renderContentMaximized();
    }

    /**
     * Configure the main menu items for the admin interface.
     * Items are organized by role and functionality.
     * 
     * @return iterable The menu items configuration
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        // Content Management Section
        yield MenuItem::section('Content Management');
        // Future menu items will be added here as entities are created
        
        // Form Management Section  
        yield MenuItem::section('Forms & Subscriptions');
        // Future menu items will be added here as entities are created
        
        // System Section
        yield MenuItem::section('System');
        // Future menu items will be added here as entities are created
        
        yield MenuItem::section();
        yield MenuItem::linkToUrl('API Documentation', 'fa fa-book', '/api/docs');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}