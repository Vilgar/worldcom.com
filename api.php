<?php
error_reporting(0);
if(!empty($_POST)) {
    $db = new mysqli("localhost", "root", "", "worldcom");
    if($db->connect_errno) {
        return "Failed to connect to MySQL: " . $db->connect_error;
    }
    if(!empty($_POST['get_country_list'])) {
        echo json_encode($db->query("SELECT * FROM countries")->fetch_all(MYSQLI_ASSOC));
        return true;
    }
    
    function get_country_list($zip_code){
        global $db;
        $query = $db->query("SELECT * FROM zip_codes LEFT JOIN countries ON countries.code = zip_codes.country_code WHERE zip_code='" . $db->real_escape_string($zip_code) . "'");
        if($query->num_rows) {
            $data = $query->fetch_assoc();
            $query = $db->query("SELECT * FROM places WHERE zip_code_id='" . $data['id'] . "'");
            if($query->num_rows) {
                $data['places'] = $query->fetch_all(MYSQLI_ASSOC);
            }
            return json_encode($data);
        }
    }
    
    if(!empty($_POST['country']) && !empty($_POST['zip_code'])) {
        
        $data = get_country_list($_POST['zip_code']);
        if(empty($data)) {
            $data = file_get_contents('http://api.zippopotam.us/'.$_POST['country'].'/'.$_POST['zip_code'].'');
            if(substr($http_response_header[0],9,3) != '200'){
                echo "Zip Code invalid! Please check.";
            } else {
                $data = json_decode($data, true);
                $db->query("INSERT INTO zip_codes (country_code, zip_code) VALUES ('".$db->real_escape_string($_POST['country'])."', '".$db->real_escape_string($_POST['zip_code'])."')");
                $zip_code_id = $db->insert_id;
                foreach ($data['places'] as $place) {
                    $place = array_values($place);
                    $db->query("INSERT INTO places (name, state, latitude, longitude, code, zip_code_id) VALUES ('".$place[0]."', '".$place[2]."', '".$place[1]."', '".$place[4]."', '".$place[3]."', '".$zip_code_id."')");
                }
                $data = get_country_list($_POST['zip_code']);
            }
        }
        echo $data;
    } else {
        echo "Please check the inputs!";
    }
} else {
    echo "Please check the inputs!";
}