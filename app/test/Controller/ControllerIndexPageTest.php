<?php

declare(strict_types=1);

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for the controller Index.
 */
class ControllerIndexPageTest extends WebTestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new IndexController();
        $this->assertInstanceOf("\App\Controller\IndexController", $controller);
    }

    // /**
    //  * Check that the controller returns a response.
    //  */
    // public function testControllerReturnsResponse()
    // {
    //     $controller = new IndexController();
    //
    //     $exp = "\Symfony\Component\HttpFoundation\Response";
    //     $res = $controller->home();
    //     $this->assertInstanceOf($exp, $res);
    // }

    // public function testControllerReturnsResponse2(SessionInterface $session)
    // {
    //     $controller = new IndexController();
    //
    //     $exp = "\Symfony\Component\HttpFoundation\Response";
    //     $res = $controller->diceView($session);
    //     $this->assertInstanceOf($exp, $res);
    // }
}
