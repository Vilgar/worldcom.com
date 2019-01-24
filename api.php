<?php
if(!empty($_POST)) {
    $db = new mysqli("localhost", "root", "", "worldcom");
    if($db->connect_errno) {
        return "Failed to connect to MySQL: " . $db->connect_error;
    }
    if(!empty($_POST['get_country_list'])) {
        echo json_encode($db->query("SELECT * FROM countries")->fetch_all(MYSQLI_ASSOC));
        return true;
    }
    if(!empty($_POST['country']) && !empty($_POST['zip_code'])) {
        
        $query = $db->query("SELECT * FROM zip_codes LEFT JOIN countries ON countries.id = zip_codes.country_id WHERE zip_code='" . $db->real_escape_string($_POST['zip_code']) . "'");
        if($query->num_rows) {
            $data = $query->fetch_assoc();
            $query = $db->query("SELECT * FROM places WHERE zip_code_id='" . $data['id'] . "'");
            if($query->num_rows) {
                $data['places'] = $query->fetch_all(MYSQLI_ASSOC);
            }
            echo json_encode($data);
            return true;
        } else {
        
        }
        
    } else {
        echo "Please check the inputs!";
    }
} else {
    echo "Please check the inputs!";
}