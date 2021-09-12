<?php

session_start();
$session_id = session_id();

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=quotes;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
}



$select = $conn->prepare("SELECT used_quote_id from used_quotes_by_session where sessionID=:sessionID");
$select->bindParam(':sessionID', $session_id);
$select->execute();
$shown_quotes = $select->fetchAll(PDO::FETCH_COLUMN);



if ($shown_quotes > 0) {
	$exclude_keys = $shown_quotes;
} else{
	$exclude_keys = array();
}



$quotes_keys = array_keys(getAllQuotes());
$remaining_keys = array_diff($quotes_keys, $exclude_keys);



if (empty($remaining_keys)) {

	echo json_encode(array('quote' => '','author' => ''));

} else{

	$rand_key = array_rand($remaining_keys);

	$insert = $conn->prepare("INSERT INTO used_quotes_by_session(sessionID, used_quote_id) VALUES (:sessionID, :used_quote_id)");
	$insert->bindParam(':sessionID', $session_id);
	$insert->bindParam(':used_quote_id', $remaining_keys[$rand_key]);
	$insert->execute();
	
	echo json_encode(getAllQuotes()[$remaining_keys[$rand_key]]);
}




/*
* Function returns list of available quotes
* @returns array
**/
function getAllQuotes() {
	return [
		'1' => [	
			'quote' => 'Monkeys are superior to men in this: when a monkey looks into a mirror, he sees a monkey.',
			'author' => 'Malcolm de Chazal'
		],
		'2' => [
			'quote' => 'They couldn\'t hit an elephant at this dist...',
			'author' => 'Gen. John Sedgwick'
		],
		'3' => [
			'quote' => 'Electronics need smoke to work. Proof: once the smoke comes out of them, they stop working.',
			'author' => 'Anonymous'
		],
		'4' => [
			'quote' => 'Giving up smoking is the easiest thing in the world. I know because I\'ve done it thousands of times.',
			'author' => 'Mark Twain'
		],
		'66' => [
			'quote' => 'I do not know with what weapons World War III will be fought, but World War IV will be fought with sticks and stones.',
			'author' => 'Albert Einstein'
		],
		'42' => [
			'quote' => 'Flying is learning how to throw yourself at the ground and miss.',
			'author' => 'Douglas Adams'
		],
		'8' => [
			'quote' => 'Do not look into laser beam with remaining eye.',
			'author' => 'Anonymous'
		],
		'6' => [
			'quote' => 'Ni jedno ljudsko biće ne može opstati samo, bez zajednice.',
			'author' => 'Dalai Lama'
		],
		'7' => [
			'quote' => 'Bolje živjeti 100 godina kao milijunaš, nego 7 dana u bijedi.',
			'author' => 'Alan Ford'
		],
		'5' => [
			'quote' => "- Have you ever heard of the Emancipation Proclamation?\n- I dont listen to hip-hop.",
			'author' => 'Chef vs General, South Park'
		],		
	];
}

