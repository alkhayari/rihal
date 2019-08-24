<?php 


require_once("./vendor/autoload.php");


$content="
	28/12/2012 is the date of brith of my cat, the cat's name is Clowy it is 7 years old now.
	We gor hte cat from Muscat, and it had a collar with a serial number of 100-222-222-111 The other cat's name is Sharen it is 5 years old, we found here from Bahla. We had a lot of cats come by this is list of all serial number of the cat's we found 
	123-557-546-111 
	225-546-748-565 
	645-485-597-597 
	595-428-458-526 
	125-544-545-662 
	With the ages of 
	8 years old. 
	6 years old. 
	9 years old 
	2.5 years old 
	4 Years old 
	9 years old 
	Will get a new cat from Chicago on 2/02/2019
";

$content = str_replace(".","",$content);

$tokens = tokenize($content);

function get_names(){
	$name_result=[];
	global $tokens;


	for ($i=0; $i < count($tokens); $i++) { 
		if ($tokens[$i] == "name") {
			$next_index=$i+1;
			if (isset($tokens[$next_index]) && $tokens[$next_index] == "is") {
				$next_index=$i+2;
				if (isset($tokens[$next_index])){
					$name_result[]= $tokens[$next_index];
				}
			}
		}
	}

	return $name_result;
}


function get_places(){
	$places_result=[];
	global $tokens;


	for ($i=0; $i < count($tokens); $i++) { 
		if ($tokens[$i] == "from") {
			$next_index=$i+1;
			if (isset($tokens[$next_index])) {
				$places_result[]= $tokens[$next_index];
			}
		}
	}

	return $places_result;
}



function get_dates(){
	global $content;

	$date_pattern = "/\d{1,2}\/\d{2}\/\d{4}/";

	preg_match_all ( $date_pattern ,$content,$date_result);
	for ($i=0; $i < count($date_result[0]); $i++) { 
		$date = DateTime::createFromFormat('d/m/Y', $date_result[0][$i]);
		$date_result[0][$i] = $date->format('m/d/y');
	}

	return $date_result[0];
}


function get_serial(){
	global $content;

	$serial_pattern = "/\d{3}\-\d{3}\-\d{3}\-\d{3}/";

	preg_match_all ( $serial_pattern ,$content,$serial_result);

	return $serial_result[0];
}

function get_age(){
	global $content;

	$age_pattern = "/\d*(?:\.\d+)? years old/";

	preg_match_all ( $age_pattern ,$content,$age_result);

	return $age_result[0];
}



$date_result   =get_dates();
$serial_result =get_serial();
$age_result    =get_age();
$name_result   =get_names();
$places_result =get_places();


echo "<br><h4>Dates</h4> ";
print_r($date_result);
echo "<br><h4>Serial No</h4> ";
print_r($serial_result);
echo "<br><h4>Ages</h4> ";
print_r($age_result);
echo "<br><h4>Names</h4> ";
print_r($name_result);
echo "<br><h4>Places</h4> ";
print_r($places_result);
