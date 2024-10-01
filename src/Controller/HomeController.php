<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    #[Route(path:'/home', name: "app_home_page")]
    public function homes(){
        return $this->render(view: 'index.html.twig');
    }
}