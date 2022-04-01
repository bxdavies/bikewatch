<?php
    include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection

    if(isset($_POST['action'])){
        if ($_POST['action'] == 'esearch'){
            $table = $_POST['table'];
            $id = intval($_POST['id']);

            if($table == 'user'){
                $eSearchDB = $DBConnection->prepare("SELECT `id` FROM `user` WHERE `id` = ?");
            }
            elseif($table == 'bike'){
                $eSearchDB = $DBConnection->prepare("SELECT `id` FROM `bike` WHERE `id` = ?");
            }
            elseif($table == 'crime'){
                $eSearchDB = $DBConnection->prepare("SELECT `id` FROM `crime` WHERE `id` = ?");
            }
           
            $eSearchDB->bind_param('i', $id);
            $eSearchDB->execute();
            $eSearchDBResults = $eSearchDB->get_result();
            $eSearchDBResult = $eSearchDBResults->fetch_assoc();
            if($eSearchDBResult['id'] == $id) {
                echo http_response_code(200);
            }
            else {
                echo http_response_code(400);
            }
        }
    }