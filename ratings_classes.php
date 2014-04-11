<?php

/**
 * Classes for Driver Insurability Rating Calculator
 *
 * @author	xy1
 * @copyright	XXX 2014
 * @since	4/9/2014
 *
 */

class Calculator {

	/**
	 * Converts blank values to zeroes for numeric fields
	 *
	 * @param	string	$input	blank string value to convert
	 * @return	int	zero
	 */
	function BlankToZero($input) {
		if ($input == '') {
			return 0;
		}
		return $input;
	}

	function __construct () {
	}

	/**
	 * Outputs CSS style definitions to web page
	 */
	function DisplayWebPageStyle() {
		include 'style.php';
		echo "<style>
			input {
				height:18px;
			}
			</style>";
	}

	/**
	 * Displays web input form for user to enter sample values for a hypothetical driver
	 *
	 * @param	associative array	$input		sample values for a driver, also used in CalculateScores
	 * @param_opt	numeric			"Income"	income in thousands
	 * @param_opt	numeric			"Age"		driver age in years
	 * @param_opt	numeric			"Incidents"	number of incidents
	 * @param_opt	numeric			"Unprocessed"	number of unprocessed incidents
	 * @param_opt	numeric			"Unresolved"	number of unresolved incidents 
	 * @param_opt	numeric			"Delayed"	number of delayed incidents
	 * @param_opt	numeric			"Type"		type of driver (1 to 4)
	 * @param_opt	numeric			"LawMinor"	number of minor legal suspensions
	 * @param_opt	numeric			"LawModerate"	number of moderate legal suspensions
	 * @param_opt	numeric			"LawMajor"	number of major legal suspensions
	 * @param_opt	numeric			"WarnModerate"	number of moderate warnings
	 * @param_opt	numeric			"WarnMajor"	number of major warnings
	 * @param_opt	blank or non-blank	"Pattern"	pattern of incidents
	 * @param_opt	blank or non-blank	"FailComply"	failure to comply with court order
	 * @param_opt	blank or non-blank	"FailHonor"	failure to honor court order
	 * @param_opt	blank or non-blank	"Transparent"	transparent driver background
	 * @param_opt	blank or non-blank	"NoLicense"	drivers license revoked or missing
	 * @param_opt	blank or non-blank	"HealthInf"	health information
	 */
	function DisplayInputForm($input) {
		$indent = "&nbsp; &nbsp; &nbsp;";

		$input['Income'] = $this->BlankToZero($input['Income']);
		$input['Age'] = $this->BlankToZero($input['Age']);
		$input['Incidents'] = $this->BlankToZero($input['Incidents']);
		$input['Unprocessed'] = $this->BlankToZero($input['Unprocessed']);
		$input['Unresolved'] = $this->BlankToZero($input['Unresolved']);
		$input['Delayed'] = $this->BlankToZero($input['Delayed']);
		$input['Type'] = $this->BlankToZero($input['Type']);
		$input['LawMinor'] = $this->BlankToZero($input['LawMinor']);
		$input['LawModerate'] = $this->BlankToZero($input['LawModerate']);
		$input['LawMajor'] = $this->BlankToZero($input['LawMajor']);
		$input['WarnModerate'] = $this->BlankToZero($input['WarnModerate']);
		$input['WarnMajor'] = $this->BlankToZero($input['WarnMajor']);

		if ($input['Pattern'] > '') {
			$Pattern_checked = 'CHECKED';
		}
		if ($input['FailComply'] > '') {
			$FailComply_checked = 'CHECKED';
		}
		if ($input['FailHonor'] > '') {
			$FailHonor_checked = 'CHECKED';
		}
		if ($input['Transparent'] > '') {
			$Transparent_checked = 'CHECKED';
		}
		if ($input['NoLicense'] > '') {
			$NoLicense_checked = 'CHECKED';
		}
		if ($input['HealthInf'] > '') {
			$HealthInf_checked = 'CHECKED';
		}
		
		// Display input form

		echo <<<EOT
				<form method=post class='lightborder thickpadding inputback' id=input_form name=input_form>
				<table class= cellspacing=0 cellpadding=0 style='width:400px;'>
				<tr><td colspan=2 class='center bold column_header'>
					<span style='float:left;'>
					<a href={$_SERVER['PHP_SELF']} class='cancel_button_small'
					style='text-decoration:none;'>Clear</a>
					</span>
					<span class=page_title>Ratings Calculator</span>
					<span style='float:right;'>
					<input type=submit class='submit_button_small' value='Calculate &rarr;'>
					</span>
				<tr><td class='labelback'>Income in thousands of dollars
					<td class='table_cell'><input id=Income name=Income value='{$input['Income']}'
					onblur='submit()' style='width: 50px;' />
				<tr><td class='labelback'>Years of age
					<td class='table_cell'><input id=Age name=Age value='{$input['Age']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Incidents
				<tr><td class='labelback'>$indent Total
					<td class='table_cell'><input id=Incidents name=Incidents value='{$input['Incidents']}'
					onblur='submit()' style='width: 40px;' />
				<tr><td class='labelback'>$indent Unprocessed
					<td class='table_cell'><input id=Unprocessed name=Unprocessed value='{$input['Unprocessed']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Unresolved
					<td class='table_cell'><input id=Unresolved name=Unresolved value='{$input['Unresolved']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Resolution delayed
					<td class='table_cell'><input id=Delayed name=Delayed value='{$input['Delayed']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Pattern of incidents?
					<td class='table_cell'><input id=Pattern name=Pattern type=checkbox $Pattern_checked
					onclick='submit()'>
				<tr><td class='labelback'>Driver type
					<td class='table_cell'><input id=Type name=Type value='{$input['Type']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Legal suspensions
				<tr><td class='labelback'>$indent Minor
					<td class='table_cell'><input id=LawMinor name=LawMinor value='{$input['LawMinor']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Moderate
					<td class='table_cell'><input id=LawModerate name=LawModerate value='{$input['LawModerate']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Major
					<td class='table_cell'><input id=LawMajor name=LawMajor value='{$input['LawMajor']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Warnings
				<tr><td class='labelback'>$indent Moderate
					<td class='table_cell'><input id=WarnModerate name=WarnModerate value='{$input['WarnModerate']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Major
					<td class='table_cell'><input id=WarnMajor name=WarnMajor value='{$input['WarnMajor']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Court actions
				<tr><td class='labelback'>$indent Failure to comply?
					<td class='table_cell'><input id=FailComply name=FailComply type=checkbox $FailComply_checked
					onclick='submit()'>
				<tr><td class='labelback'>$indent Failure to honor?
					<td class='table_cell'><input id=FailHonor name=FailHonor type=checkbox $FailHonor_checked
					onclick='submit()'>
				<tr><td class='labelback'>Transparent driver background?
					<td class='table_cell'><input id=Transparent name=Transparent type=checkbox $Transparent_checked
					onclick='submit()'>
				<tr><td class='labelback'>Competency licensing revoked/missing?
					<td class='table_cell'><input id=NoLicense name=NoLicense type=checkbox $NoLicense_checked
					onclick='submit()'>
				<tr><td class='labelback'>Health information
					<td class='table_cell'><input id=HealthInf name=HealthInf type=checkbox $HealthInf_checked
					onclick='submit()'>
				</table>
				</form>
EOT;
	}

	/**
	 * Calculates scores for ratings elements based on input, either from web form or from other source
	 *
	 * @param	associative array	$input		sample values for a hypothetical driver - see DisplayInputForm
	 * @return	associative array	$Points		see list of options in docs for DisplayInputForm
	 */
	function CalculateScores($input) {
		$debug = 0;

		//////////////////////////////////
		// Age of driver

		$Points['Age'] = 0;
		if ($input['Age'] < 1) {
			$Points['Age'] = "NR";
		}
		else if ($input['Age'] >= 1 && $input['Age'] < 4) {
			$Points['Age'] = 10 * $input['Age'] / 4;
		}
		else {
			$Points['Age'] = 10;
		}

		//////////////////////////////////
		// Complaint volume
		
		$Category = '';
		$base = 0;
		$factor = 0;
		$Categories = array (
				1 => array (
					"lower" => 0,
					"upper" => 0.5,
					"base" => 0.5,
					"factor" => "double"
					),
				2 => array (
					"lower" => 0.5,
					"upper" => 1,
					"base" => 1,
					"factor" => "double"
					),
				3 => array (
					"lower" => 1,
					"upper" => 3,
					"base" => 3,
					"factor" => 1.00
					),
				4 => array (
					"lower" => 3,
					"upper" => 5,
					"base" => 5,
					"factor" => 1.00
					),
				5 => array (
					"lower" => 5,
					"upper" => 8,
					"base" => 8,
					"factor" => 1.00
					),
				6 => array (
					"lower" => 8,
					"upper" => 12,
					"base" => 12,
					"factor" => 0.50
					),
				7 => array (
					"lower" => 12,
					"upper" => 20,
					"base" => 20,
					"factor" => 0.50
					),
				8 => array (
					"lower" => 20,
					"upper" => 50,
					"base" => 50,
					"factor" => 0.50
					),
				9 => array (
					"lower" => 50,
					"upper" => 100,
					"base" => 99,
					"factor" => 0.50
					),
				10 => array (
					"lower" => 100,
					"upper" => 300,
					"base" => 298,
					"factor" => 0.50
					),
				11 => array (
					"lower" => 300,
					"upper" => 800,
					"base" => 792,
					"factor" => 0.50
					),
				12 => array (
					"lower" => 800,
					"upper" => 1500,
					"base" => 1484,
					"factor" => 0.50
					),
				13 => array (
					"lower" => 1500,
					"upper" => 5000,
					"base" => 4898,
					"factor" => 0.50
					),
				14 => array (
					"lower" => 5000,
					"upper" => 20000,
					"base" => 19593,
					"factor" => 0.50
					),
				15 => array (
					"lower" => 20000,
					"upper" => 9999999,
					"base" => 39186,
					"factor" => 0.50
					)
			);
		foreach ($Categories as $cat => $valarray) {
			foreach ($valarray as $key => $val) {
				if ($key == 'lower') {
					$lower = $val;
				}
				else if ($key == 'upper') {
					$upper = $val;
				}
				else if ($key == 'base') {
					$base = $val;
				}
				else if ($key == 'factor') {
					$factor = $val;
				}
			}
			if ($input['Income'] >= $lower && $input['Income'] < $upper) {
				$Category = $cat;
				break;
			}
		}

		if ($debug == 1) {
			echo "Incidents: " . $input['Incidents'] . "<br/>\n";
			echo "Complaint volume<br/>";
			echo "<span class=indented50>Income category: " . $Category . "</span><br/>";
			echo "Base: " . $base . "<br/>\n";
			echo "Factor: " . $factor . "<br/>\n";
		}

		$Points['Incidents'] = 15;
		if ($debug == 1) {
			echo "<table class='indented50'>";
		}
		for ($points = 15; $points >= 0; $points = $points - 3) {
			if ($debug == 1) {
				echo "<tr>";
				echo "<td>" . $points . " points: ";
			}
			if ($points == 15) {
				$incident_threshold = $base;
			}
			else if ($points > 0) {
				if ($factor == "double") {
					$incident_threshold = $incident_threshold * 2;
				}
				else {
					$incident_threshold = $incident_threshold + ($base * $factor);
				}
			}
			else {
				$incident_threshold++;
			}
			if ($debug == 1) {
				echo "<td>" . $incident_threshold . " incidents";
			}
			if ($input['Incidents'] >= $incident_threshold) {
				$Points['Incidents'] = $points;
			}
		}
		if ($debug == 1) {
			echo "</table>";
			echo "<br/>";
		}

		//////////////////////////////////
		// Unprocessed incidents

		$Points['Unprocessed'] = 0;
		$piece = 0.4 + 0.03 * sqrt($input['Income']);
		if ($input['Unprocessed'] > 1 && $input['Income'] < 25) {
			$Points['Unprocessed'] = 40 - (40 / (1 + exp(-5 * ($input['Unprocessed'] - $piece ) / $piece )));
		}
		else {
			$Points['Unprocessed'] = 40 - (25 / (1 + exp(-5 * ($input['Unprocessed'] - $piece ) / $piece )));
		}
		
		//////////////////////////////////
		// Unresolved incidents
		
		$Points['Unresolved'] = 0;
		$piece = 3 + 0.1 * sqrt($input['Income']);
		$Points['Unresolved'] = 30 - (30 / (1 + exp(-5 * ($input['Unresolved'] - $piece ) / $piece )));

		//////////////////////////////////
		// Resolution delayed
		
		$Points['Delayed'] = 0;
		if ( $input['Delayed'] < ( 0.4 + 2 * sqrt($input['Income']) ) ) {
			$Points['Delayed'] = 5;
		}
		
		//////////////////////////////////
		// Pattern of incidents
		
		$Points['Pattern'] = 0;
		if ($input['Pattern'] > '') {
			$Points['Pattern'] = -11;
		}
		
		//////////////////////////////////
		// Driver type
		
		$Points['Type'] = 0;
		if ($input['Type'] == '1') {
			$Points['Type'] = -41;
		}
		
		//////////////////////////////////
		// Drivers license
		
		$Points['NoLicense'] = 0;
		if ($input['NoLicense'] > '') {
			$Points['NoLicense'] = -41;
		}

		//////////////////////////////////
		// Legal suspensions

		$Points['Law'] = ($input['LawMinor'] * -4) + ($input['LawModerate'] * -10) + ($input['LawMajor'] * -25);

		//////////////////////////////////
		// Warnings
		
		$Points['Warn'] = 0;
		if ($input['WarnModerate'] == 1) {
			$Points['Warn'] = $Points['Warn'] - 5;
		}
		else if ($input['WarnModerate'] >= 2 && $input['WarnModerate'] <= 3) {
			$Points['Warn'] = $Points['Warn'] - 10;
		}
		else if ($input['WarnModerate'] >= 4) {
			$Points['Warn'] = $Points['Warn'] - 15;
		}
		if ($input['WarnMajor'] >= 1) {
			$Points['Warn'] = $Points['Warn'] - (41 * $input['WarnMajor']);
		}

		//////////////////////////////////
		// Court actions
		
		$Points['Med'] = 0;
		if ($input['FailComply'] > '') {
			$Points['Med'] = $Points['Med'] - 20;
		}
		if ($input['FailHonor'] > '') {
			$Points['Med'] = $Points['Med'] - 41;
		}
		
		//////////////////////////////////
		// Health information
		
		if ($input['HealthInf'] > '') {
			$Points['HealthInf'] = -41;
		}
		else {
			$Points['HealthInf'] = 0;
		}

		//////////////////////////////////
		// Transparent driver background
		
		if ($input['Transparent'] > '') {
			$Points['Transparent'] = 0;
		}
		else {
			$Points['Transparent'] = -5;
		}

		return $Points;
	}

	/**
	 * Displays the results of calculations performed in CalculateScores function, either to web as HTML table or terminal
	 *
	 * @param	string			$output_mode	either 'web' or 'terminal'
	 * @param	associative array	$Points		see list of options in docs for DisplayInputForm
	 */
	function DisplayScores($output_mode, $Points) {

		// Calculate total points
		foreach ($Points as $p => $v) {
			$TotalPoints = $TotalPoints + $v;
		}

		if ($output_mode == 'web') {
			echo "<table class='lightborder thickpadding beigeback' style='width:625px;'>";
			echo "<tr><td>&nbsp;<td class='bold'>Element <td colspan=2 class='right bold'>Points Awarded";
			echo "<tr><td>&nbsp;";
			
			echo "<tr><td class='table_cell'>1<td class='table_cell' style='width:250px;'>
				Age of driver<td class='table_cell'>0 to 10<td class='labelback right' style='width:25px;'>" .
				round($Points['Age']);
			echo "<tr><td class='table_cell'>2<td class='table_cell'>
				Complaint volume <td class='table_cell'>0 to 15<td class='labelback right'>" .
				round($Points['Incidents']);
			echo "<tr><td class='table_cell'>3<td class='table_cell'>
				Unprocessed<td class='table_cell'>0 to 40<td class='labelback right'>" .
				round($Points['Unprocessed']);
			echo "<tr><td class='table_cell'>4<td class='table_cell'>
				Unresolved<td class='table_cell'>0 to 30<td class='labelback right'>" .
				round($Points['Unresolved']);
			echo "<tr><td class='table_cell'>5<td class='table_cell'>
				Resolution relayed<td class='table_cell'>0 to 5<td class='labelback right'>" .
				round($Points['Delayed']);
			echo "<tr><td class='table_cell'>6<td class='table_cell'>
				Pattern<td class='table_cell'>0 to -11<td class='labelback right'>" .
				round($Points['Pattern']);
			echo "<tr><td class='table_cell'>7<td class='table_cell'>
				Driver type<td class='table_cell'>0 to -41<td class='labelback right'>" .
				round($Points['Type']);
			echo "<tr><td class='table_cell'>8<td class='table_cell'>
				Competency licensing<td class='table_cell'>0 to -41<td class='labelback right'>" .
				round($Points['NoLicense']);
			echo "<tr><td class='table_cell'>9<td class='table_cell'>
				Legal suspensions<td class='table_cell'>0, -4/minor, -10/moderate, -25/major<td class='labelback right'>" .
				round($Points['Law']);
			echo "<tr><td class='table_cell'>10<td class='table_cell'>
				Warnings<td class='table_cell'>0, -5, -10, or -15 for moderates, -41/major<td class='labelback right'>" .
				round($Points['Warn']);
			echo "<tr><td class='table_cell'>11<td class='table_cell'>
				Mediation/arbitration<td class='table_cell'>0, -20, or -41<td class='labelback right'>" .
				round($Points['Med']);
			echo "<tr><td class='table_cell'>12<td class='table_cell'>
				Health information<td class='table_cell'>0 or -41<td class='labelback right'>" .
				round($Points['HealthInf']);
			echo "<tr><td class='table_cell'>13<td class='table_cell'>
				Transparent driver background<td class='table_cell'>0 or -5<td class='labelback right'>" .
				round($Points['Transparent']);
			echo "<tr><td>&nbsp;";
			echo "<tr><td>&nbsp;<td class='bold'>Total <td>&nbsp;
				<td class='bold right'>" . round($TotalPoints);
			echo "</table>";
		}
		else {  // terminal display
			foreach ($Points as $p => $v) {
				echo $p . " points: " . round($v) . "\n";
			}
			echo "Total points: " . round($TotalPoints) . "\n";
		}
	}

}

?>
