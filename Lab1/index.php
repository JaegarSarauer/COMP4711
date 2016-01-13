<?php
$temp = "jaegar";
echo 'Hi, my name is ' . $temp;
$temp = "forehead";
echo '<br/>I am a ' . $temp;
$temp = 99;
echo '<br/>my level is ' . $temp;


$hoursworked = $_GET['hours'];
$rate = 66;
if ($hoursworked > 40) {
    $total = $hoursworked * $rate * 1.5;
} else {
    $total = $hoursworked * $rate;
}
echo ($total > 0) ? "</br>you owe me $" . $total : "</br>You owe me nothing.";
?>