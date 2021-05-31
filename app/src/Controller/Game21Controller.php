<?php

namespace App\Controller;

use Emeu17\Dice\DiceHand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game21Controller extends AbstractController
{

    /**
     * @Route("/startGame", name="startGame")
    */
    public function startgame(SessionInterface $session): Response
    {
        //if session variables are not set, give them value of 0
        $session->set('noRounds', $session->get('noRounds') ?? 0);
        $session->set('compScore', $session->get('compScore') ?? 0);
        $session->set('playScore', $session->get('playScore') ?? 0);

        return $this->render('game21.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/startGame/reset", name="resetGame")
    */
    public function resetGame(SessionInterface $session): RedirectResponse
    {
        // $session = new Session();
        // $session->start();
        $session->clear();
        // $session->set('tesst', 'test123');

        return $this->redirectToRoute('startGame');

    }

    /**
     * @Route("/startGame/process", name="processGame")
    */
    public function processGame(Request $request, SessionInterface $session): RedirectResponse
    {
        $dices = (int) $request->request->get('dices') ?? 2;
        $session->set('diceHand', new DiceHand($dices));

        return $this->redirectToRoute('diceGame');
    }

    /**
     * @Route("/diceGame", name="diceGame")
    */
    public function diceGame(SessionInterface $session): Response
    {
        $callable = $session->get('diceHand');
        $throw = $callable->getLastRoll();
        $sum = $callable->getSum();

        return $this->render('diceGame.html.twig', [
            'throw' => $throw,
            'sum' => $sum,
        ]);
    }

    /**
     * @Route("/diceGame/process2", name="processThrow")
    */
    public function processThrow(SessionInterface $session, Request $request): RedirectResponse
    {
        $stop = $request->request->get('stop') ?? null;

        if ($stop) {
            return $this->redirectToRoute('diceResult');
        }
        $callable = $session->get('diceHand');
        $callable->roll();
        $session->set('diceHand', $callable);
        if ($callable->getSum() >= 21) {
            return $this->redirectToRoute('diceResult');
        }

        return $this->redirectToRoute('diceGame');
    }

    /**
     * @Route("/diceGame/result", name="diceResult")
    */
    public function diceResult(SessionInterface $session): Response
    {
        $callable = $session->get('diceHand');
        $throw = $callable->getLastRoll();
        $sum = $callable->getSum();

        $result = $this->getWinner($callable, $session);
        $session->set('noRounds', 1 + $session->get('noRounds'));
        $session->remove('diceHand');

        return $this->render('diceResult.html.twig', [
            'throw' => $throw,
            'sum' => $sum,
            'result' => $result,
        ]);
    }

    /**
     * Returns the winner in a DiceHand object
     *
     */
    public function getWinner($callable, $session): string
    {
        $sum = $callable->getSum();
        if ($callable->getSum() == 21) {
            $res = "CONGRATULATIONS! You got 21!";
            // $winner = "player";
            $session->set('playScore', 1 + $session->get('playScore'));
            return $res;
        }
        if ($callable->getSum() > 21) {
            $res = "You passed 21 and lost, sum: " . $sum;
            // $winner = "computer";
            $session->set('compScore', 1 + $session->get('compScore'));
            return $res;
        }
        // if sum less than 21, simulate computer throws
        $computerScore = $callable->simulateComputer((int) $sum);
        if($computerScore <= 21) {
            $res = "Computer wins, got sum = " . $computerScore . ", your sum = " . $sum;
            // $winner = "computer";
            $session->set('compScore', 1 + $session->get('compScore'));
            return $res;
        }
        $res = "You win, computer got sum = " . $computerScore . ", your sum = " . $sum;
        // $winner = "player";
        $session->set('playScore', 1 + $session->get('playScore'));
        return $res;
    }
}
