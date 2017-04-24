<?php
// FUNCTIONS


function checkDates ($START, $END) {
	if ($START > $END) {
		$tmpDATE = $START;
		$START = $END;
		$END = $tmpDATE;
		}
	return 	array ($START, $END);
}		
		