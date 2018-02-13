<!DOCTYPE php>

<?php


$request = "curl -X GET -H \"Content-Type: application/json\" -d '{\"username\":\"******\",\"password\":\"********\"}' \"https://testing.3dusernet.com/aws/api/sign_in.json\"";
$output = shell_exec($request);
echo "<pre>$output</pre>";


	//Create the token variable for use in php
    $temp = json_decode($output);
	$tokenVal = $temp->token;

	//echo $tokenVal;
	//Set the Toekn in Terminal for this session
	$request2 = "token=\"$tokenVal\"";
	echo $request2;



	//Other Variables Required
	//Variables to insert into the sections
	$GroupId = '16';

	//Creatio Name and Descr
	$ProjName = 'DM Test 2';
	$ProjDesc = 'DM test Description';

	//To update project details
	$ProjName1 = 'DM Test 3';
	$ProjDesc1 = 'DM test Description 3';

	//Creation Lat / Long
	$ProjLat = '10';
	$ProjLong = '10';

	//Update Lat / Long
	$ProjLat1 = '10';
	$ProjLong1 = '10';

	$ProjID = '736';

	$LibID = '';


?>

