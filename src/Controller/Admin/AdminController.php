<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{

    #[IsGranted(attribute: "ROLE_ADMIN")]
    #[Route(path: '/admin', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/admin.html.twig');
    }
}
