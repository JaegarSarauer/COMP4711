

<?php
/**
 * This is a very simple tic-tac-toe game written in PHP which allows one user to
 * play a simple AI for high-stakes.
 * 
 * @author Jaegar Sarauer A00925935
*/


/**
 * This line gets the board string from the GET method.
 */
$board_string = $_GET['board'];

/**
 * This line parses the board string from the GET method, into an array
 * representing the board pieces of the Tic-Tac-Toe game.
 */
$squares = str_split($board_string); //index 0 = top left, index 8 = bottom right

/**
 * This counts to see if the passed in enteries of spaces is equal to 9 or not.
 * If it isn't, then it must be a new visitor. This will then fill the board
 * up with the empty dashes for a new game.
 */
if (count($squares) != 9) {
    for ($i = 0; $i < 9; $i++) {
        $squares[i] = '-';
    }
}

/**
 * This block of code carries out basic control for the game on each turn.
 * It begins by creating the new game board of the page out of the previously
 * loaded board. After creating the board, the testWinner function is called 
 * from within the game object. This will test to see who (or nobody) has won
 * the game.
 * 
 * If somebody has won the game, the game will display to the user who has won,
 * and tell the game object to not allow any more moves, as the game has ended.
 * If the game hasn't ended, the AI player will make its move. Upon making the
 * move, the board will be tested again for a winner, disabling the game again
 * if there was a winner.
 * 
 * If there was no winner, the game board will be displayed, and the player will
 * be able to make their next move.
 */
$game = new Game($squares);
$is_winner = $game->testWinner();
if ($is_winner === '-') {
    $game->AIMove();
    if ($game->testWinner() === 'x') {
        echo "I win!!";
    }
} else if ($is_winner === 'o') {
    echo "You win!";
} else if ($is_winner === 'x') {
    echo "I win!!";
}
$game->display();
    
    
/**
 * This class is a representation of the game board. It will hold all functions
 * that have to do with move taking, from both the AI and user, and will also 
 * check to see if there is a winner. It will also display the board that it has
 * been constructed with.
 */
class Game {
    /**
     * @var char array : This char array represents each board piece of the game.
     * It is constructed by the constructor.
     */
    var $squares;
    
    /**
     * The constructor for this class, requires a board to be passed in.
     * 
     * Only use of this is to instantiate the board for reference by other
     * functions within Game class.
     * 
     * @param type $squares_in = A char array representing the board.
     */
    function __construct($squares_in) {
        $this->squares = $squares_in;
    }
    
    /**
     * Very simple AI which will choose a random empty spot and claim it with an
     * 'x'.
     */
    function AIMove() {
        $free = 0;
        for ($i = 0; $i < 9; $i++) {
            if ($this->squares[$i] === '-') {
                $free++;
            }
        }
        $free -= rand(0, $free);
        for ($i = 0; $i < 9; $i++) {
            if ($this->squares[$i] === '-') {
                if ($free > 1) {
                    $free--;
                } else {
                    $this->squares[$i] = 'x';
                    return;
                }
            }
        }
    }
    
    /**
     * This function simply creates a table and calls showCell, to insert each
     * board icon into the table.
     * 
     * It also constructs a button to easily reset the game.
     */
    function display() {
        echo '<table cols="3" style="font-size:large; font-weight:bold">';
        echo '<tr>';
        for ($pos=0; $pos<9; $pos++) {
            echo $this->showCell($pos);
            if ($pos % 3 === 2) { 
                echo '</tr><tr>'; 
            }
        }
        echo '</tr>';
        echo '</table>';
        echo    '<form method="get">
                    <input type="text" name="board" value="---------" hidden=""><br>
                    <input type="submit" value="Play Again">
                </form>';
    }
    
    /**
     * This function will link all empty spots to a link of a new board which
     * exists with that spot taken by the player.
     * The purpose of this function is to create a tree of possible moves that
     * the player may take (1 depth), and allow the user to click on a choice.
     * This function will not allow clicking on any empty spot if the game has
     * ended.
     * 
     * @param type $which = Which board piece will this be linking and testing
     * if it's free.
     * @return Returns a link which will be inserted into the table. This link
     * will point to a new board state where the user has taken that choice.
     */
    function showCell($which) {
        $token = $this->squares[$which];
        if ($token <> '-') { 
            return '<td>' . $token . '</td>';
        }
        $this->newsquares = $this->squares; 
        $this->newsquares[$which] = 'o';
        $move = implode($this->newsquares);
        $link = './?board=' . $move;
        if ($this->testWinner() === '-') {
            return '<td><a style="text-decoration: none;" href="' . $link . '">-</a></td>';
        } else {
            return '<td>-</td>';
        }
    }
    
    /**
     * This function uses the board pieces that this class has been constructed with,
     * and undergoes logical testing to see if there has been a winner on the board.
     * IF there was a winner, the letter representing the winner will be returned,
     * if there was no winner, a '-' character will be returned instead.
     * 
     * @return string The character which represents the winner. If there is no
     * winner, expect a '-' to be returned.
     */
    function testWinner() {
    
        for ($i = 0; $i < 3; $i++) {
            if ($this->squares[($i * 3)] !== '-' && $this->squares[($i * 3) + 1] === $this->squares[$i * 3] && $this->squares[($i * 3) + 2] === $this->squares[$i * 3]) {
                return $this->squares[$i * 3];
            } else if ($this->squares[$i] !== '-' && $this->squares[$i + 3] === $this->squares[$i] && $this->squares[$i + 6] === $this->squares[$i]) {
                return $this->squares[$i];
            }
        }

        if (($this->squares[4] !== '-') && (($this->squares[0] === $this->squares[4] && $this->squares[8] === $this->squares[4]) || ($this->squares[2] === $this->squares[4] && $this->squares[6] === $this->squares[4]))) {
            return $this->squares[4];
        }

        return '-';
    }
}
?>