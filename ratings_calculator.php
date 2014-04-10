<?php

/**
 * Driver Insurability Rating Calculator
 *
 * @author	xy1
 * @copyright	XXX 2014
 * @since	4/9/2014
 *
 */


// load class definitions
include 'ratings_classes.php';

// get input, if any, from browser POST method
$input = $_POST;

// set default values for web form, if needed
if ( empty($input) ) {
	$input['Age'] = 5;
	$input['Transparent'] = 'on';
}

$Calculator = new Calculator();

$Calculator->DisplayWebPageStyle();

echo "<table><tr>";

// display web input form
echo "<td valign=top>";
$Calculator->DisplayInputForm($input);

// calculate scores and display as html table
echo "<td valign=top>";
$Points = $Calculator->CalculateScores($input);
$Calculator->DisplayScores('web', $Points);

echo "</table>";

?>
