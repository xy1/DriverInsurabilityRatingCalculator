<?php

/**
 * Unit tests for Driver Insurability Rating Calculator
 *
 * @author	xy1
 * @copyright	XXX 2014
 * @since	4/9/2014
 */

// load class definitions
include 'ratings_classes.php';


/**
 * Tests successful calculation of total score (0 to 100 points) of rating for a sample driver
 *
 * @param	associative array	$input		sample values for a driver
 * @param_opt	numeric			"Income"	revenue in thousands
 * @param_opt	numeric			"Age"		driver age in years
 * @param_opt	numeric			"Incidents"	number of incidents
 * @param_opt	numeric			"Unprocessed"	number of unprocessed incidents
 * @param_opt	numeric			"Unresolved"	number of unresolved incidents
 * @param_opt	numeric			"Delayed"	number of delayed incidents
 * @param_opt	numeric			"Type"		type of driver (1 to 4)
 * @param_opt	numeric			"LawMinor"	number of minor government suspensions
 * @param_opt	numeric			"LawModerate"	number of moderate government suspensions
 * @param_opt	numeric			"LawMajor"	number of major government suspensions
 * @param_opt	numeric			"WarnModerate"	number of moderate warnings
 * @param_opt	numeric			"WarnMajor"	number of major warnings
 * @param_opt	blank or non-blank	"Pattern"	pattern of incidents
 * @param_opt	blank or non-blank	"FailComply"	failure to comply with court order
 * @param_opt	blank or non-blank	"FailHonor"	failure to honor court order
 * @param_opt	blank or non-blank	"Transparent"	transparent driver background
 * @param_opt	blank or non-blank	"NoLicense"	drivers license revoked or missing
 * @param_opt	blank or non-blank	"HealthInf"	health information
 */
function TestTotalPoints($input) {
	// calls calculator
	$Calculator = new Calculator();
	$Points = $Calculator->CalculateScores($input);

	// totals points
	foreach ($Points as $p => $v) {
		$TotalPoints = $TotalPoints + $v;
	}

	//$Calculator->DisplayScores('terminal', $Points);
	return round($TotalPoints);
}

// unit tests

assert ( TestTotalPoints( array() ) == 85 );
assert ( TestTotalPoints( array( "Age" => 10, "Transparent" => "on" ) ) == 100 );
assert ( TestTotalPoints( array( "Age" => 0, "Transparent" => "on" ) ) == 90 );
assert ( TestTotalPoints( array( "Age" => 1, "Transparent" => "on" ) ) == 92 );
assert ( TestTotalPoints( array( "Age" => 2, "Transparent" => "on" ) ) == 95 );
assert ( TestTotalPoints( array( "Age" => 3, "Transparent" => "on" ) ) == 97 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "HealthInf" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "Pattern" => "on" ) ) == 89 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "FailComply" => "on" ) ) == 80 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "FailHonor" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "FailComply" => "on", "FailHonor" => "on" ) ) == 39 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "NoLicense" => "on" ) ) == 59 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnModerate" => 1 ) ) == 95 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnModerate" => 2 ) ) == 90 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnModerate" => 3 ) ) == 90 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnModerate" => 4 ) ) == 85 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnMajor" => 1 ) ) == 59 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnMajor" => 2 ) ) == 18 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "WarnModerate" => 1, "WarnMajor" => 1 ) ) == 54 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "LawMinor" => 1 ) ) == 96 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "LawMinor" => 2 ) ) == 92 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "LawMinor" => 3, "LawModerate" => 2, "LawMajor" => 1 ) ) == 43 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "Type" => "1" ) ) == 59 );
assert ( TestTotalPoints( array( "Age" => 33, "Transparent" => "on", "Type" => "4" ) ) == 100 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Unprocessed" => 1 ) ) == 75 );
assert ( TestTotalPoints( array( "Income" => 900, "Age" => 33, "Transparent" => "on", "Unprocessed" => 1 ) ) == 94 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Unresolved" => 1 ) ) == 99 );
assert ( TestTotalPoints( array( "Income" => 900, "Age" => 33, "Transparent" => "on", "Unresolved" => 1 ) ) == 99 );
assert ( TestTotalPoints( array( "Income" => 9000, "Age" => 33, "Transparent" => "on", "Unresolved" => 1 ) ) == 100 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Unprocessed" => 1, "Unresolved" => 1 ) ) == 74 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Incidents" => 7 ) ) == 97 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Incidents" => 12 ) ) == 91 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Incidents" => 700 ) ) == 85 );
assert ( TestTotalPoints( array( "Income" => 900, "Age" => 33, "Transparent" => "on", "Incidents" => 1 ) ) == 100 );
assert ( TestTotalPoints( array( "Income" => 900, "Age" => 33, "Transparent" => "on", "Incidents" => 3000 ) ) == 94 );
assert ( TestTotalPoints( array( "Income" => 900, "Age" => 33, "Transparent" => "on", "Incidents" => 6000 ) ) == 85 );
assert ( TestTotalPoints( array( "Income" => 100, "Age" => 33, "Transparent" => "on", "Incidents" => 500 ) ) == 97 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on", "Delayed" => 5 ) ) == 95 );
assert ( TestTotalPoints( array( "Income" => 100, "Age" => 33, "Transparent" => "on", "Delayed" => 5 ) ) == 100 );
assert ( TestTotalPoints( array( "Income" => 100, "Age" => 33, "Transparent" => "on", "Delayed" => 500 ) ) == 95 );
assert ( TestTotalPoints( array( "Income" => 100, "Age" => 2, "Transparent" => "on", "Delayed" => 500 ) ) == 90 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on",
	"Incidents" => 4, "Unprocessed" => 3, "Unresolved" => 2, "Delayed" => 1 ) ) == 56 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on",
	"Incidents" => 1, "Unprocessed" => 2, "Unresolved" => 3, "Delayed" => 4 ) ) == 41 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on",
	"Incidents" => 1, "Unprocessed" => 2, "Unresolved" => 3, "Delayed" => 4,
	"LawMinor" => 1, "LawModerate" => 2, "LawMajor" => 3 ) ) == -58 );
assert ( TestTotalPoints( array( "Income" => 1, "Age" => 33, "Transparent" => "on",
	"Incidents" => 1, "Unprocessed" => 2, "Unresolved" => 3, "Delayed" => 4,
	"LawMinor" => 1, "LawModerate" => 2, "LawMajor" => 3, "WarnModerate" => 1, "WarnMajor" => 2 ) ) == -145 );

?>
