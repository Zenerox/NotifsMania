<?php

namespace App\Controller;

use App\Repository\NotifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NotifController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(NotifRepository $repo): Response
    {
        $notifs = $repo->findAll();
        return $this->render('notif/index.html.twig', [
            'notifs' => $notifs
        ]);
    }
}
