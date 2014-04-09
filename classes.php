<?php

//////////////////////////////////
// classes.php
// Classes for 13-Factor Score Calculator
// 04/09/2014
//////////////////////////////////

class Calculator {

	function BlankToZero($input) {
		if ($input == '') {
			return 0;
		}
		return $input;
	}

	function __construct () {
	}

	function DisplayWebPageStyle() {
		include 'style.php';
		echo "<style>
			input {
				height:18px;
			}
			</style>";
	}

	function DisplayInputForm($input) {
		$indent = "&nbsp; &nbsp; &nbsp;";

		$input['Digitization'] = $this->BlankToZero($input['Digitization']);
		$input['History'] = $this->BlankToZero($input['History']);
		$input['Readings'] = $this->BlankToZero($input['Readings']);
		$input['Unfiled'] = $this->BlankToZero($input['Unfiled']);
		$input['Unfinished'] = $this->BlankToZero($input['Unfinished']);
		$input['Depth'] = $this->BlankToZero($input['Depth']);
		$input['Time'] = $this->BlankToZero($input['Time']);
		$input['XYZFirst'] = $this->BlankToZero($input['XYZFirst']);
		$input['XYZSecond'] = $this->BlankToZero($input['XYZSecond']);
		$input['XYZThird'] = $this->BlankToZero($input['XYZThird']);
		$input['AZSecond'] = $this->BlankToZero($input['AZSecond']);
		$input['AZThird'] = $this->BlankToZero($input['AZThird']);

		if ($input['System'] > '') {
			$System_checked = 'CHECKED';
		}
		if ($input['FailComply'] > '') {
			$FailComply_checked = 'CHECKED';
		}
		if ($input['FailAccept'] > '') {
			$FailAccept_checked = 'CHECKED';
		}
		if ($input['Supplied'] > '') {
			$Supplied_checked = 'CHECKED';
		}
		if ($input['NoCard'] > '') {
			$NoCard_checked = 'CHECKED';
		}
		if ($input['TradeInf'] > '') {
			$TradeInf_checked = 'CHECKED';
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
					<span class=page_title>Score Calculator</span>
					<span style='float:right;'>
					<input type=submit class='submit_button_small' value='Calculate &rarr;'>
					</span>
				<tr><td class='labelback'>Digitization factor
					<td class='table_cell'><input id=Digitization name=Digitization value='{$input['Digitization']}'
					onblur='submit()' style='width: 50px;' />
				<tr><td class='labelback'>Years in business
					<td class='table_cell'><input id=History name=History value='{$input['History']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Readings
				<tr><td class='labelback'>$indent Total
					<td class='table_cell'><input id=Readings name=Readings value='{$input['Readings']}'
					onblur='submit()' style='width: 40px;' />
				<tr><td class='labelback'>$indent Unfiled
					<td class='table_cell'><input id=Unfiled name=Unfiled value='{$input['Unfiled']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Unfinished
					<td class='table_cell'><input id=Unfinished name=Unfinished value='{$input['Unfinished']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Depth
					<td class='table_cell'><input id=Depth name=Depth value='{$input['Depth']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>System?
					<td class='table_cell'><input id=System name=System type=checkbox $System_checked
					onclick='submit()'>
				<tr><td class='labelback'>Time
					<td class='table_cell'><input id=Time name=Time value='{$input['Time']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Aged government actions
				<tr><td class='labelback'>$indent First
					<td class='table_cell'><input id=XYZFirst name=XYZFirst value='{$input['XYZFirst']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Second
					<td class='table_cell'><input id=XYZSecond name=XYZSecond value='{$input['XYZSecond']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Third
					<td class='table_cell'><input id=XYZThird name=XYZThird value='{$input['XYZThird']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>A to Z
				<tr><td class='labelback'>$indent Second
					<td class='table_cell'><input id=AZSecond name=AZSecond value='{$input['AZSecond']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>$indent Third
					<td class='table_cell'><input id=AZThird name=AZThird value='{$input['AZThird']}'
					onblur='submit()' style='width: 25px;' />
				<tr><td class='labelback'>Insurance
				<tr><td class='labelback'>$indent Fail-safe comply?
					<td class='table_cell'><input id=FailComply name=FailComply type=checkbox $FailComply_checked
					onclick='submit()'>
				<tr><td class='labelback'>$indent Fail-safe acceptance?
					<td class='table_cell'><input id=FailAccept name=FailAccept type=checkbox $FailAccept_checked
					onclick='submit()'>
				<tr><td class='labelback'>Supplied xyz?
					<td class='table_cell'><input id=Supplied name=Supplied type=checkbox $Supplied_checked
					onclick='submit()'>
				<tr><td class='labelback'>Card cancelled/missing?
					<td class='table_cell'><input id=NoCard name=NoCard type=checkbox $NoCard_checked
					onclick='submit()'>
				<tr><td class='labelback'>Trade infraction?
					<td class='table_cell'><input id=TradeInf name=TradeInf type=checkbox $TradeInf_checked
					onclick='submit()'>
				</table>
				</form>
EOT;
	}

	function CalculateScores($input) {
		$debug = 0;

		//////////////////////////////////
		// History factor

		$Points['History'] = 0;
		if ($input['History'] < 1) {
			$Points['History'] = "NR";
		}
		else if ($input['History'] >= 1 && $input['History'] < 4) {
			$Points['History'] = 10 * $input['History'] / 4;
		}
		else {
			$Points['History'] = 10;
		}

		//////////////////////////////////
		// Readings
		
		$Category = '';
		$base = 0;
		$factor = 0;
		if ($input['Digitization'] >= 0 && $input['Digitization'] <= 0.5) {
			$Category = 1;
			$base = 0.5;
			$factor = "double";
		}
		else if ($input['Digitization'] >= 0.5 && $input['Digitization'] < 1) {
			$Category = 2;
			$base = 1;
			$factor = "double";
		}
		else if ($input['Digitization'] >= 1 && $input['Digitization'] < 3) {
			$Category = 3;
			$base = 3;
			$factor = 1.00;
		}
		else if ($input['Digitization'] >= 3 && $input['Digitization'] < 5) {
			$Category = 4;
			$base = 5;
			$factor = 1.00;
		}
		else if ($input['Digitization'] >= 5 && $input['Digitization'] < 8) {
			$Category = 5;
			$base = 8;
			$factor = 1.00;
		}
		else if ($input['Digitization'] >= 8 && $input['Digitization'] < 12) {
			$Category = 6;
			$base = 12;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 12 && $input['Digitization'] < 20) {
			$Category = 7;
			$base = 20;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 20 && $input['Digitization'] < 50) {
			$Category = 8;
			$base = 50;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 50 && $input['Digitization'] < 100) {
			$Category = 9;
			$base = 99;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 100 && $input['Digitization'] < 300) {
			$Category = 10;
			$base = 298;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 300 && $input['Digitization'] < 800) {
			$Category = 11;
			$base = 792;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 800 && $input['Digitization'] < 1500) {
			$Category = 12;
			$base = 1484;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 1500 && $input['Digitization'] < 5000) {
			$Category = 13;
			$base = 4898;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 5000 && $input['Digitization'] < 20000) {
			$Category = 14;
			$base = 19593;
			$factor = 0.50;
		}
		else if ($input['Digitization'] >= 20000) {
			$Category = 15;
			$base = 39186;
			$factor = 0.50;
		}

		if ($debug == 1) {
			echo "Readings: " . $input['Readings'] . "<br/>\n";
			echo "Readings<br/>";
			echo "<span class=indented50>Digitization category: " . $Category . "</span><br/>";
			echo "Base: " . $base . "<br/>\n";
			echo "Factor: " . $factor . "<br/>\n";
		}

		$Points['Readings'] = 15;
		if ($debug == 1) {
			echo "<table class='indented50'>";
		}
		for ($points = 15; $points >= 0; $points = $points - 3) {
			if ($debug == 1) {
				echo "<tr>";
				echo "<td>" . $points . " points: ";
			}
			if ($points == 15) {
				$reading_threshold = $base;
			}
			else if ($points > 0) {
				if ($factor == "double") {
					$reading_threshold = $reading_threshold * 2;
				}
				else {
					$reading_threshold = $reading_threshold + ($base * $factor);
				}
			}
			else {
				$reading_threshold++;
			}
			if ($debug == 1) {
				echo "<td>" . $reading_threshold . " readings";
			}
			if ($input['Readings'] >= $reading_threshold) {
				$Points['Readings'] = $points;
			}
		}
		if ($debug == 1) {
			echo "</table>";
			echo "<br/>";
		}

		//////////////////////////////////
		// Unfiled readings

		$Points['Unfiled'] = 0;
		$piece = 0.4 + 0.03 * sqrt($input['Digitization']);
		if ($input['Unfiled'] > 1 && $input['Digitization'] < 25) {
			$Points['Unfiled'] = 40 - (40 / (1 + exp(-5 * ($input['Unfiled'] - $piece ) / $piece )));
		}
		else {
			$Points['Unfiled'] = 40 - (25 / (1 + exp(-5 * ($input['Unfiled'] - $piece ) / $piece )));
		}
		
		//////////////////////////////////
		// Unfinished readings
		
		$Points['Unfinished'] = 0;
		$piece = 3 + 0.1 * sqrt($input['Digitization']);
		$Points['Unfinished'] = 30 - (30 / (1 + exp(-5 * ($input['Unfinished'] - $piece ) / $piece )));

		//////////////////////////////////
		// Depth
		
		$Points['Depth'] = 0;
		if ( $input['Depth'] < ( 0.4 + 2 * sqrt($input['Digitization']) ) ) {
			$Points['Depth'] = 5;
		}
		
		//////////////////////////////////
		// System
		
		$Points['System'] = 0;
		if ($input['System'] > '') {
			$Points['System'] = -11;
		}
		
		//////////////////////////////////
		// Time
		
		$Points['Time'] = 0;
		if ($input['Time'] == '1') {
			$Points['Time'] = -41;
		}
		
		//////////////////////////////////
		// Card cancelled
		
		$Points['NoCard'] = 0;
		if ($input['NoCard'] > '') {
			$Points['NoCard'] = -41;
		}

		//////////////////////////////////
		// XYZ

		$Points['XYZ'] = ($input['XYZFirst'] * -4) + ($input['XYZSecond'] * -10) + ($input['XYZThird'] * -25);

		//////////////////////////////////
		// A to Z
		
		$Points['AZ'] = 0;
		if ($input['AZSecond'] == 1) {
			$Points['AZ'] = $Points['AZ'] - 5;
		}
		else if ($input['AZSecond'] >= 2 && $input['AZSecond'] <= 3) {
			$Points['AZ'] = $Points['AZ'] - 10;
		}
		else if ($input['AZSecond'] >= 4) {
			$Points['AZ'] = $Points['AZ'] - 15;
		}
		if ($input['AZThird'] >= 1) {
			$Points['AZ'] = $Points['AZ'] - (41 * $input['AZThird']);
		}

		//////////////////////////////////
		// Insurance
		
		$Points['Ins'] = 0;
		if ($input['FailComply'] > '') {
			$Points['Ins'] = $Points['Ins'] - 20;
		}
		if ($input['FailAccept'] > '') {
			$Points['Ins'] = $Points['Ins'] - 41;
		}
		
		//////////////////////////////////
		// Trade infraction
		
		if ($input['TradeInf'] > '') {
			$Points['TradeInf'] = -41;
		}
		else {
			$Points['TradeInf'] = 0;
		}

		//////////////////////////////////
		// Supplied xyz
		
		if ($input['Supplied'] > '') {
			$Points['Supplied'] = 0;
		}
		else {
			$Points['Supplied'] = -5;
		}

		return $Points;
	}

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
				History<td class='table_cell'>0 to 10<td class='labelback right' style='width:25px;'>" .
				round($Points['History']);
			echo "<tr><td class='table_cell'>2<td class='table_cell'>
				Readings<td class='table_cell'>0 to 15<td class='labelback right'>" .
				round($Points['Readings']);
			echo "<tr><td class='table_cell'>3<td class='table_cell'>
				Unfiled<td class='table_cell'>0 to 40<td class='labelback right'>" .
				round($Points['Unfiled']);
			echo "<tr><td class='table_cell'>4<td class='table_cell'>
				Unfinished<td class='table_cell'>0 to 30<td class='labelback right'>" .
				round($Points['Unfinished']);
			echo "<tr><td class='table_cell'>5<td class='table_cell'>
				Depth<td class='table_cell'>0 to 5<td class='labelback right'>" .
				round($Points['Depth']);
			echo "<tr><td class='table_cell'>6<td class='table_cell'>
				System<td class='table_cell'>0 to -11<td class='labelback right'>" .
				round($Points['System']);
			echo "<tr><td class='table_cell'>7<td class='table_cell'>
				Time<td class='table_cell'>0 to -41<td class='labelback right'>" .
				round($Points['Time']);
			echo "<tr><td class='table_cell'>8<td class='table_cell'>
				Card<td class='table_cell'>0 to -41<td class='labelback right'>" .
				round($Points['NoCard']);
			echo "<tr><td class='table_cell'>9<td class='table_cell'>
				XYZ<td class='table_cell'>0, -4/first, -10/second, -25/third<td class='labelback right'>" .
				round($Points['XYZ']);
			echo "<tr><td class='table_cell'>10<td class='table_cell'>
				A to Z<td class='table_cell'>0, -5, -10, or -15 for second, -41/third<td class='labelback right'>" .
				round($Points['AZ']);
			echo "<tr><td class='table_cell'>11<td class='table_cell'>
				Insurance<td class='table_cell'>0, -20, or -41<td class='labelback right'>" .
				round($Points['Ins']);
			echo "<tr><td class='table_cell'>12<td class='table_cell'>
				Trade infraction<td class='table_cell'>0 or -41<td class='labelback right'>" .
				round($Points['TradeInf']);
			echo "<tr><td class='table_cell'>13<td class='table_cell'>
				Supplied xyz<td class='table_cell'>0 or -5<td class='labelback right'>" .
				round($Points['Supplied']);
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
