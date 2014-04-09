<?php

//////////////////////////////////
// calculator.php
// 13-Factor Score Calculator
// 04/09/2014
//////////////////////////////////


include 'classes.php';

$input = $_POST;

// set default values
if ( empty($input) ) {
	$input['History'] = 5;
	$input['Supplied'] = 'on';
}

$Calculator = new Calculator();
$Calculator->DisplayWebPageStyle();

echo "<table><tr>";
echo "<td valign=top>";
$Calculator->DisplayInputForm($input);
echo "<td valign=top>";
$Points = $Calculator->CalculateScores($input);
$Calculator->DisplayScores('web', $Points);
echo "</table>";

?>
