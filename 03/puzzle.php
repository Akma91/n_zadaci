<?php

require('bootstrap_header.php');

function isSolvable($randKeys) {
	$inversion_counter = 0;
  
	for ($i = 0; $i < count($randKeys); $i++) {
	  for ($j = 0; $j < $i; $j++) {
		if ($randKeys[$j] > $randKeys[$i]){
			$inversion_counter++;
		}

	  }
	}
  
	return $inversion_counter % 2 == 0;
  }

/*
* Returns list of available puzzle images
**/
function getPuzzleImages()
{
	return [[
			'title' => 'Normal',
			'image' => 'plain.png'
		],[
			'title' => 'Pokemon',
			'image' => 'pikachu.jpg'
		],[
			'title' => 'Flowers',
			'image' => 'flowers.jpg'
		],[
			'title' => 'Solving the puzzle you are, yes?',
			'image' => 'yoda.jpg'
		],[
			'title' => 'Bang!',
			'image' => 'bebop.jpg'
		],[
			'title' => 'Doggy style',
			'image' => 'dog-and-cat.jpg'
		]
	];
}




echo '<div class="row align-items-center">';

echo '<div class="col p-0"><div class="dropdown w-100">
<button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  Choose image
</button>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';


foreach(getPuzzleImages() as $puzle_image){

	$image_slug = explode('.', $puzle_image['image'])[0];

	echo '<li><a class="dropdown-item" href="?image='.$puzle_image['image'].'" id="'.$image_slug.'">'.$puzle_image['title'].'</a></li>';

}

echo '</ul>
</div></div>';

echo '<div class="col p-0">
<form action="" method="get">
	<input type="hidden" name="image" value="'.(isset($_GET["image"]) ? $_GET["image"] : 'plain.png').'">
	<input type="hidden" name="shuffle" value="true">
	<button type="submit" class="btn btn-dark w-100">Shuffle</button>
</form>
</div>';

echo '</div>';







echo '<div class="row">';
echo '<div class="col p-0">';
echo '<img id="image-to-shuffle" width="512" height="512" style="margin: 0px; max-width: 100%;" class="img-fluid mx-auto d-block" src="img/'.(isset($_GET["image"]) ? $_GET["image"] : 'plain.png').'" alt="'.(isset($_GET["image"]) ? $_GET["image"] : 'plain').'">';
echo '</div>';
echo '</div>';


$puzzle_size = 16;
$axis_size = sqrt($puzzle_size);
$size = getimagesize('img/'.(isset($_GET["image"]) ? $_GET["image"] : 'plain.png'))[0];
$tile_size = $size/$axis_size;

$tiled_canvas = '<div class="row">';
$tiled_canvas .= '<div class="col p-0">';
$tiled_canvas .= '<table id="matrix" style="margin: 0px auto;" class="w-50">';

for($x = 0; $x < $axis_size; $x++){

	$tiled_canvas .= '<tr>';


	for($y = 0; $y < $axis_size; $y++){

		$tiled_canvas .= '<td><canvas width="'.$tile_size.'px" height="'.$tile_size.'px" id="'.$x.'_'.$y.'"></canvas></td>';

	}



	$tiled_canvas .= '</tr>';

}


$tiled_canvas .= '</table>';
$tiled_canvas .= '</div>';
$tiled_canvas .= '</div>';


echo $tiled_canvas;




if(isset($_GET["shuffle"])){

	$draw_canvas = '<script>';

	$draw_canvas = '<script>';

	$draw_canvas .= 'const image = document.getElementById(\'image-to-shuffle\');';
	$draw_canvas .= 'const table = document.getElementById(\'matrix\');';

	$tiles_array = [];

	$tiles_counter = 1;
	$matching_string = '';
	for($x = 0; $x < $axis_size; $x++){
		for($y = 0; $y < $axis_size; $y++){

			$draw_canvas .= 'var canvas_'.$x.'_'.$y.' = document.getElementById(\''.$x.'_'.$y.'\');';
    		$draw_canvas .= 'var ctx_'.$x.'_'.$y.' = canvas_'.$x.'_'.$y.'.getContext(\'2d\');';

			if(($x == ($axis_size - 1)) && ($y == ($axis_size - 1))){

				$matching_string .= '__';
				
			}else{
				$matching_string .= $x.'_'.$y;
			}
			

			$tiles_array[strval($tiles_counter)] = array($x, $y);
			$tiles_counter++;
		}
	}

	$draw_canvas .= 'matching_string = "'.$matching_string.'";';

	$rand_keys = range(1, 15);

	do{
		shuffle($rand_keys);
	}while(!isSolvable($rand_keys));
	

	$shuffled_tiles_array = [];

	foreach($rand_keys as $rand_key){

		$shuffled_tiles_array[] = $tiles_array[strval($rand_key)];

	}



	$draw_canvas .= 'window.addEventListener(\'load\', e => {';


		$x_pos = 0;
		$y_pos = 0;

	$empty_field = array();
	$filled_fields = array();

	for($x = 0; $x < $axis_size; $x++){
		for($y = 0; $y < $axis_size; $y++){

			if($x == 3 && $y == 3){

				$draw_canvas .= 'ctx_'.$x.'_'.$y.'.fillStyle = "white";';
				$draw_canvas .= 'ctx_'.$x.'_'.$y.'.fillRect(0, 0, 256, 256);';


				continue;

			}

			$draw_canvas .= 'ctx_'.$x.'_'.$y.'.drawImage(image, '.$y_pos.', '.$x_pos.', 256, 256, 0, 0, image.width/'.$axis_size.', image.height/'.$axis_size.');';


			$y_pos = $y_pos + $tile_size;


		}

		$y_pos = 0;
		$x_pos = $x_pos + $tile_size;
	}



	$draw_canvas .= '});';


	$draw_canvas .= 'table.height = image.height;';


	for($x = 0; $x < $axis_size; $x++){
		for($y = 0; $y < $axis_size; $y++){

			$draw_canvas .= 'canvas_'.$x.'_'.$y.'.height = image.height/'.$axis_size.';';
			$draw_canvas .= 'canvas_'.$x.'_'.$y.'.width = image.width/'.$axis_size.';';

		}
	}


	$draw_canvas .= 'var arr = [];';



	$shuffled_tiles_array_counter = 0;
	for($x = 0; $x < $axis_size; $x++){
		for($y = 0; $y < $axis_size; $y++){

			if($x == 3 && $y == 3){
				break;
			}


			$draw_canvas .= 'var order_element = document.getElementsByTagName(\'tr\')['.$x.'].getElementsByTagName(\'td\')['.$y.'].firstChild;';
			$draw_canvas .= 'if(order_element){';
			$draw_canvas .= 'document.body.appendChild(order_element);';
			$draw_canvas .= '}';

			$shuffled_tiles_array_counter++;

		}
	}
      

	$shuffled_tiles_array_counter = 0;
	for($x = 0; $x < $axis_size; $x++){
		for($y = 0; $y < $axis_size; $y++){

			if($x == 3 && $y == 3){
				break;
			}


			$draw_canvas .= 'var order_element = document.getElementsByTagName(\'tr\')['.$x.'].getElementsByTagName(\'td\')['.$y.'];';
			$draw_canvas .= 'order_element.appendChild(canvas_'.$shuffled_tiles_array[$shuffled_tiles_array_counter][0].'_'.$shuffled_tiles_array[$shuffled_tiles_array_counter][1].');';


			$shuffled_tiles_array_counter++;

		}
	}


	$draw_canvas .= 'document.getElementsByTagName(\'tr\')[3].getElementsByTagName(\'td\')[3].firstChild.remove();';

	$draw_canvas .= 'document.getElementsByTagName(\'tr\')[2].getElementsByTagName(\'td\')[3].firstChild.style.cursor = \'pointer\';';
	$draw_canvas .= 'document.getElementsByTagName(\'tr\')[2].getElementsByTagName(\'td\')[3].firstChild.onclick = function() {updateTiles(\'3\', \'3\', \'2\', \'3\')};';



	$draw_canvas .= 'document.getElementsByTagName(\'tr\')[3].getElementsByTagName(\'td\')[2].firstChild.style.cursor = \'pointer\';';

	$draw_canvas .= 'document.getElementsByTagName(\'tr\')[3].getElementsByTagName(\'td\')[2].firstChild.onclick = function() {updateTiles(\'3\', \'3\', \'3\', \'2\')};';



	
    $draw_canvas .= 'image.classList.remove("d-block");';
	$draw_canvas .= 'image.style.display = "none";';



	$draw_canvas .= '</script>';

	echo $draw_canvas;

}




echo '<script src="update_tiles.js"></script>';




require('footer.php');




