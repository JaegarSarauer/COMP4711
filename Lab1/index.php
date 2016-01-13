<?php
$board_string = $_GET['board'];
$squares = str_split($board_string); //index 0 = top left, index 8 = bottom right

$game = new Game($squares);
$is_winner = $game->testWinner();
echo ($is_winner == null) ? "No winner" : $is_winner . " wins!";

    
    
class Game {
    var $squares;
    
    function __construct($squares_in) {
        $this->squares = $squares_in;
    }
    
    //takes in an array of 3x3 of a tic-tac-toe board and computes a winner.
    //Returns null character on no winner, 'X' if X player wins, and 'O' if O player wins.
    function testWinner() {
    
    for ($i = 0; $i < count($this->squares) / 3; $i++) {
        if ($this->squares[$i] != '-' && $this->squares[($i * 3) + 1] == $this->squares[$i * 3] && $this->squares[($i * 3) + 2] == $this->squares[$i * 3]) {
            return $this->squares[$i * 3];
        } else if ($this->squares[$i] != '-' && $this->squares[$i + 3] == $this->squares[0] && $this->squares[$i + 6] == $this->squares[$i]) {
            return $this->squares[$i];
        }
    }

    if (($this->squares[4] != '-') && (($this->squares[0] == $this->squares[4] && $this->squares[8] == $this->squares[4]) || ($this->squares[2] == $this->squares[4] && $this->squares[6] == $this->squares[4]))) {
        return $this->squares[4];
    }
    
    return null;
    }
}
?>