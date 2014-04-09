<?php

//////////////////////////////////
// unit_tests.php
// Unit Tests for 13-Factor Score Calculator
// 04/09/2014
//////////////////////////////////

/*
Notes:
Array keys and data types for available factors:
	"Digitization" - numeric
	"History" - numeric
	"Readings" - numeric
	"Unfiled" - numeric
	"Unfinished" - numeric
	"Depth" - numeric
	"Time" - numeric
	"XYZFirst" - numeric
	"XYZSecond" - numeric
	"XYZThird" - numeric
	"AZSecond" - numeric
	"AZThird" - numeric
	"System" - blank or non-blank
	"FailComply" - blank or non-blank
	"FailAccept" - blank or non-blank
	"Supplied" - blank or non-blank
	"NoCard" - blank or non-blank
	"TradeInf" - blank or non-blank
*/

include 'classes.php';

function TestTotalPoints($input) {
	$Calculator = new Calculator();
	$Points = $Calculator->CalculateScores($input);
	foreach ($Points as $p => $v) {
		$TotalPoints = $TotalPoints + $v;
	}
	//$Calculator->DisplayScores('terminal', $Points);
	return round($TotalPoints);
}

assert ( TestTotalPoints( array() ) == 85 );
assert ( TestTotalPoints( array( "History" => 10, "Supplied" => "on" ) ) == 100 );
assert ( TestTotalPoints( array( "History" => 0, "Supplied" => "on" ) ) == 90 );
assert ( TestTotalPoints( array( "History" => 1, "Supplied" => "on" ) ) == 92 );
assert ( TestTotalPoints( array( "History" => 2, "Supplied" => "on" ) ) == 95 );
assert ( TestTotalPoints( array( "History" => 3, "Supplied" => "on" ) ) == 97 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "TradeInf" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "System" => "on" ) ) == 89 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "FailComply" => "on" ) ) == 80 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "FailAccept" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "FailComply" => "on", "FailAccept" => "on" ) ) == 39 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "NoCard" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZSecond" => 1 ) ) == 95 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZSecond" => 2 ) ) == 90 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZSecond" => 3 ) ) == 90 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZSecond" => 4 ) ) == 85 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZThird" => 1 ) ) == 59 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZThird" => 2 ) ) == 18 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "AZSecond" => 1, "AZThird" => 1 ) ) == 54 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "XYZFirst" => 1 ) ) == 96 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "XYZFirst" => 2 ) ) == 92 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "XYZFirst" => 3, "XYZSecond" => 2, "XYZThird" => 1 ) ) == 43 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "Time" => "1" ) ) == 59 );
assert ( TestTotalPoints( array( "History" => 33, "Supplied" => "on", "Time" => "4" ) ) == 100 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Unfiled" => 1 ) ) == 75 );
assert ( TestTotalPoints( array( "Digitization" => 900, "History" => 33, "Supplied" => "on", "Unfiled" => 1 ) ) == 94 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Unfinished" => 1 ) ) == 99 );
assert ( TestTotalPoints( array( "Digitization" => 900, "History" => 33, "Supplied" => "on", "Unfinished" => 1 ) ) == 99 );
assert ( TestTotalPoints( array( "Digitization" => 9000, "History" => 33, "Supplied" => "on", "Unfinished" => 1 ) ) == 100 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Unfiled" => 1, "Unfinished" => 1 ) ) == 74 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Readings" => 7 ) ) == 97 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Readings" => 12 ) ) == 91 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Readings" => 700 ) ) == 85 );
assert ( TestTotalPoints( array( "Digitization" => 900, "History" => 33, "Supplied" => "on", "Readings" => 1 ) ) == 100 );
assert ( TestTotalPoints( array( "Digitization" => 900, "History" => 33, "Supplied" => "on", "Readings" => 3000 ) ) == 94 );
assert ( TestTotalPoints( array( "Digitization" => 900, "History" => 33, "Supplied" => "on", "Readings" => 6000 ) ) == 85 );
assert ( TestTotalPoints( array( "Digitization" => 100, "History" => 33, "Supplied" => "on", "Readings" => 500 ) ) == 97 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on", "Depth" => 5 ) ) == 95 );
assert ( TestTotalPoints( array( "Digitization" => 100, "History" => 33, "Supplied" => "on", "Depth" => 5 ) ) == 100 );
assert ( TestTotalPoints( array( "Digitization" => 100, "History" => 33, "Supplied" => "on", "Depth" => 500 ) ) == 95 );
assert ( TestTotalPoints( array( "Digitization" => 100, "History" => 2, "Supplied" => "on", "Depth" => 500 ) ) == 90 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on",
	"Readings" => 4, "Unfiled" => 3, "Unfinished" => 2, "Depth" => 1 ) ) == 56 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on",
	"Readings" => 1, "Unfiled" => 2, "Unfinished" => 3, "Depth" => 4 ) ) == 41 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on",
	"Readings" => 1, "Unfiled" => 2, "Unfinished" => 3, "Depth" => 4,
	"XYZFirst" => 1, "XYZSecond" => 2, "XYZThird" => 3 ) ) == -58 );
assert ( TestTotalPoints( array( "Digitization" => 1, "History" => 33, "Supplied" => "on",
	"Readings" => 1, "Unfiled" => 2, "Unfinished" => 3, "Depth" => 4,
	"XYZFirst" => 1, "XYZSecond" => 2, "XYZThird" => 3, "AZSecond" => 1, "AZThird" => 2 ) ) == -145 );

?>
