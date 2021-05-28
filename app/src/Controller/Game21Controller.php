<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game21Controller extends AbstractController
{

    /**
     * @Route("/startGame", name="startGame")
    */
    public function startgame(SessionInterface $session): Response
    {
        if ( null == $session->get('noRounds')) {
            $session->set('noRounds', 0);
            $session->set('compScore', 0);
            $session->set('playScore', 0);
        }

        return $this->render('game21.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/startGame/reset")
    */
    public function resetGame(SessionInterface $session): RedirectResponse
    {
        // $session = new Session();
        // $session->start();
        $session->clear();
        // $session->set('tesst', 'test123');

        return $this->redirectToRoute('startGame');

    }
}
