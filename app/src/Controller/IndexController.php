<?php

namespace App\Controller;

use Emeu17\Dice\Dice;
use Emeu17\Dice\DiceHand;
use Emeu17\Dice\GraphicalDice;
use Emeu17\Dice\DiceInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class IndexController extends AbstractController
{

    /**
     * @Route("/")
    */
    public function hello(): Response
    {
        return $this->render('message.html.twig', [
            'message' => "Hello and Welcome",
        ]);
    }

    /**
     * @Route("/dice_view")
    */
    public function diceView(SessionInterface $session): Response
    {

        // $die = new Dice();
        $dicehand = new DiceHand();
        $graphdice = new GraphicalDice();
        $graphrolls = 6;
        $graphres = [];
        $graphclass = [];
        for ($i = 0; $i < $graphrolls; $i++) {
            $graphres[] = $graphdice->roll();
            $graphclass[] = $graphdice->asString();
        }

        return $this->render('dice.html.twig', [
            // 'die' => $die,
            'dicehand' => $dicehand,
            'graphres' => $graphres,
            'graphclass' => $graphclass,
            'session' => $session,
        ]);
    }
}
