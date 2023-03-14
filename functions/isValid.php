<?php
//function to test if author_id or category_id is a valid id in the database returns boolean

//takes author_id, category_id, or a quote id and the corresponding model
function isValid($id, $model) {

    //set the id on the model
    $model->id = $id;
    
    //call the read_single query on the model
    $result = $model->read_single();

    //return the result of the query
    return $result;
}

?>