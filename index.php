<?php
include 'config.php';
function sanitizeDate($date){
	$date = str_replace("/", "", $date);
	$date = [
		substr($date, 0, 2),
		substr($date, 2, 2),
		substr($date, 4, 4)
	];

	return $date[2] .$date[1] .$date[0];
}

ob_start();

$db = fopen("$db", "r");
$csv = fopen("$csv", "w");
$timestamp = fopen("$timestamp", "w");

fwrite($timestamp, date("Y-m-d G:i:s") ."\n");

$headers = ['GroupID', 'SubGroupID', 'FirstName', 'LastName', 'DOB', 'Gender', 'PhoneNumber', 'Address1', 'Address2', 'City', 'State', 'ZipCode_PostalCode', 'MID', 'SSN', 'Extra2', 'Extra3', 'Extra5', 'Insurance'];

fputcsv($csv, $headers, ";");

do {

	$line = fgets($db);
	$line = utf8_decode($line);

	if (substr($line, 0, 1) == "?") {
		$input = [
			trim(substr($line, 1, 3)),
			trim(substr($line, 4, 3)),
			trim(substr($line, 7, 7)),
			trim(substr($line, 14, 9)),
			trim(substr($line, 23, 10)),
			trim(substr($line, 33, 10)),
			trim(substr($line, 43, 50)),
			trim(substr($line, 93, 1)),
			trim(substr($line, 94, 10)),
			trim(substr($line, 104, 10)),
			trim(substr($line, 114, 50)),
			trim(substr($line, 164, 10)),
			trim(substr($line, 174, 20)),
			trim(substr($line, 194, 50)),
			trim(substr($line, 244, 10)),
			trim(substr($line, 254, 10)),
			trim(substr($line, 264, 1)),
			trim(substr($line, 265, 40)),
			trim(substr($line, 305, 50)),
			trim(substr($line, 355, 10))
		];
	} else {
		$input = [
			trim(substr($line, 0, 3)),
			trim(substr($line, 3, 3)),
			trim(substr($line, 6, 7)),
			trim(substr($line, 13, 9)),
			trim(substr($line, 22, 10)),
			trim(substr($line, 32, 10)),
			trim(substr($line, 42, 50)),
			trim(substr($line, 92, 1)),
			trim(substr($line, 93, 10)),
			trim(substr($line, 103, 10)),
			trim(substr($line, 113, 50)),
			trim(substr($line, 163, 10)),
			trim(substr($line, 173, 20)),
			trim(substr($line, 193, 50)),
			trim(substr($line, 243, 10)),
			trim(substr($line, 253, 10)),
			trim(substr($line, 263, 1)),
			trim(substr($line, 264, 40)),
			trim(substr($line, 304, 50)),
			trim(substr($line, 354, 10))
		];
	}

	$input[4] = sanitizeDate($input[4]);
	$input[5] = sanitizeDate($input[5]);
	$input[9] = sanitizeDate($input[9]);
	$input[15] = sanitizeDate($input[15]);

	$output = [
		'3',
		'3',
		$input[10],
		$input[13],
		$input[15],
		$input[16],
		'',
		'',
		'',
		'',
		$input[17],
		'',
		$input[3],
		$input[14],
		$input[4] ." " .$input[5],
		'',
		$input[19],
		$input[0] .$input[1] .$input[2] .$input[3]
	];
	
	$output = implode(";", $output);
	fwrite($csv, $output ."\n");

} while (!feof($db));

fwrite($timestamp, date("Y-m-d G:i:s") ."\n");
fclose ($db);
fclose($csv);
ob_end_flush();
?>