Framework Symfony
==========

Kmom04
-------------

Refactoring of code from kmom01 through kmom03 in order
to create equivalent game(s) in Symfony framework.

From Kmom01:

Initial dice game. The game is "21". Player vs computer. Can be reached
through link "Game 21" in navbar. Based on classes in /src:
- Dice: represents a dice with chosen amount of faces.
- DiceHand: represents a chosen amount of dices.
- GraphicalDice: inherits from the Dice class - also has the
    possibility to get class-name in order to print out
    a graphical representation of the dice.

From Kmom02:

Refactoring of code to include controllers.
New class Yatzy to play yatzy game on application.


From Kmom03:

Unit-testing of controller classes and Dice classes
can be found under folder *test*. Can be performed running
*make phpunit*. Result of test can be found in *build*-map -> coverage.
