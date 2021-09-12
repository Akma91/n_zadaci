<?php

session_start();
$session_id = session_id();

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=mapa_hrvatske;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
}



$select_svg = $conn->prepare("SELECT * from county");
$select_svg->execute();
$map_data = $select_svg->fetchAll();


if(isset($_GET['d'])){

    $year = substr($_GET['d'], 0, 4);
    $month = substr($_GET['d'], 4, 2);
    $day = substr($_GET['d'], 6, 2);

    if(strlen($_GET['d']) == 8 && checkdate(intval($month), intval($day), intval($year))){

      $passed_date = $year.'-'.$month.'-'.$day;

    }else{

      http_response_code(404);
      die();

    }

} else{

  $passed_date = date("Y-m-d");

}




$select_stats_by_date = $conn->prepare("SELECT * from county_stats where stats_date=:stats_date");
$select_stats_by_date->bindParam(':stats_date', $passed_date);
$select_stats_by_date->execute();
$county_stats = $select_stats_by_date->fetchAll();


$county_stats_array = [];

foreach($county_stats as $county_stat){

  $county_stats_array[$county_stat["county_id"]] = ["red" => $county_stat["red"], "blue" => $county_stat["blue"]];

}



echo '<html>';
echo '<head>';
echo '</head>';
echo '<body>';


//
echo '<div style="text-align: center">';
echo '<h1>Mapa Hrvatske</h1>';
echo '<h3>Datum: '.$passed_date.'</h3>';
echo '<svg style="display: block; margin-left: auto; margin-right: auto; width: 40%;" height="800">';

foreach($map_data as $map_data_row){

    $count_id = $map_data_row["county_id"];

    $parsed = '';



    $parsed = explode('L',$map_data_row["svg_path"]);
    $parsed = implode(' L',$parsed);

    $parsed = explode(',',$parsed);
    $parsed = implode(' ',$parsed);



    if(isset($county_stats_array[$count_id])){

      $red_colour = intval($county_stats_array[$count_id]["red"] * 204 / 100);
      $blue_colour = intval($county_stats_array[$count_id]["blue"] * 204 / 100);

      echo '<path id="'.$map_data_row["county_id"].'" stroke="LightCoral" fill=rgb('.$red_colour.',0,'.$blue_colour.') d="'.$parsed.'" />';

    }else{

      echo '<path id="'.$map_data_row["county_id"].'" stroke="LightCoral" fill="lightGrey" d="'.$parsed.'" />';

    }
    

    echo '';

}

echo '</svg>';
echo '</div>';
echo '</body>';
