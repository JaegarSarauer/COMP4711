<?php
$board_string = $_GET['board'];
$squares = str_split($board_string); //index 0 = top left, index 8 = bottom right


$is_winner = testWinner($squares);
echo ($is_winner == null) ? "No winner" : $is_winner . " wins!";
//takes in an array of 3x3 of a tic-tac-toe board and computes a winner.
//Returns null character on no winner, 'X' if X player wins, and 'O' if O player wins.
function testWinner($squares) {
    
    for ($i = 0; $i < count($squares) / 3; $i++) {
        if ($squares[$i] != '-' && $squares[($i * 3) + 1] == $squares[$i * 3] && $squares[($i * 3) + 2] == $squares[$i * 3]) {
            return $squares[$i * 3];
        } else if ($squares[$i] != '-' && $squares[$i + 3] == $squares[0] && $squares[$i + 6] == $squares[$i]) {
            return $squares[$i];
        }
    }

    if (($squares[4] != '-') && (($squares[0] == $squares[4] && $squares[8] == $squares[4]) || ($squares[2] == $squares[4] && $squares[6] == $squares[4]))) {
        return $squares[4];
    }
    
    return null;
    }
?>