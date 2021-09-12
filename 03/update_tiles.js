function updateTiles(e_x, e_y, f_x, f_y){


    
    var rows = document.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {

        var cells = rows[i].getElementsByTagName('td');

        for (var j = 0; j < cells.length; j++) {




            if(e_x == i && e_y == j){

                if(cells[j].firstChild){

                    var canvas_to_replace = cells[j].firstChild;

                }else{

                    var cell_to_insert = cells[j];

                }


            } else if(f_x == i && f_y == j){

                var clicked_canvas = cells[j].firstChild;

            }

        }

    }




    if (canvas_to_replace == null){

        
        cell_to_insert.appendChild(clicked_canvas);

    }else{

        canvas_to_replace.replaceWith(clicked_canvas);
        canvas_to_replace.style.cursor = '';
        canvas_to_replace.removeAttribute("onclick");

    }

    


    var rows = document.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {

        var cells = rows[i].getElementsByTagName('td');

        for (var j = 0; j < cells.length; j++) {


            if (cells[j].firstChild) {

                cells[j].firstChild.style.cursor = '';
                cells[j].firstChild.onclick = null;

            }

        }
    }


    var local_matching_string = '';


    var rows = document.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {

        var cells = rows[i].getElementsByTagName('td');

        for (var j = 0; j < cells.length; j++) {

            if (cells[j].firstChild) {


                local_matching_string += cells[j].firstChild.id;



            } else{

                local_matching_string += '__';

                var i_praznog = i;
                var j_praznog = j;

            }

            

        }
    }




    if(matching_string == local_matching_string){
        alert("Slagalica složena");
        image.classList.add("d-block");
	    image.style.display = "block";
        table.style.display = "none";
        //window.location.href.split('?')[0];
    }

    



    if(j_praznog < 3){

        rows[i_praznog].cells[j_praznog + 1].firstChild.style.cursor = 'pointer';
        rows[i_praznog].cells[j_praznog + 1].firstChild.onclick = function() {updateTiles(i_praznog, j_praznog, i_praznog, (j_praznog + 1))};
        
    }

    if(j_praznog > 0){

        rows[i_praznog].cells[j_praznog - 1].firstChild.style.cursor = 'pointer';
        rows[i_praznog].cells[j_praznog - 1].firstChild.onclick = function() {updateTiles(i_praznog, j_praznog, i_praznog, j_praznog - 1)};

    }

    if(i_praznog < 3){

        rows[i_praznog + 1].children[j_praznog].firstChild.style.cursor = 'pointer';
        rows[i_praznog + 1].children[j_praznog].firstChild.onclick = function() {updateTiles(i_praznog, j_praznog, i_praznog + 1, j_praznog)};

    }

    if(i_praznog > 0){

        rows[i_praznog - 1].children[j_praznog].firstChild.style.cursor = 'pointer';
        rows[i_praznog - 1].children[j_praznog].firstChild.onclick = function() {updateTiles(i_praznog, j_praznog, i_praznog - 1, j_praznog)};

    }




};