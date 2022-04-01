<?php
    include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection

    if(isset($_POST['action'])){
        if ($_POST['action'] == 'getNumberOfRows'){
            $numberOfRows = $DBConnection->query("SELECT COUNT(*) FROM crime");
            $row = $numberOfRows->fetch_assoc();
            echo $row["COUNT(*)"];
        }

        elseif ($_POST['action'] == 'getData') {
            $filters = $_POST['filters'];
            $offset = $_POST['offset'];
            $limit = $_POST['limit'];
            
            // Need to prevent SQL injection here!

            //GROUP BY `bike`.`id`
            if ($filters['id'] == '0' && $filters['report_date'] == '0' && $filters['last_name'] == '0' && $filters['last_name'] == '0' && $filters['crime_date'] == '0' && $filters['status'] == '0'){
                $crimes = $DBConnection->prepare("SELECT `crime`.`id`, `crime`.`report_date`, `user`.`title`, `user`.`first_name`, `user`.`last_name`, `bike_image`.`image` , `bike`.`mpn`, `bike`.`brand`, `crime`.`crime_date`, `crime`.`status` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` INNER JOIN `user` ON `user`.id = `bike`.`user` INNER JOIN `bike_image` ON `bike`.`id` = `bike_image`.`bike` LIMIT ?, ?;");
                
            }
            else{
                $filtersSQL = [];
                foreach($filters as $key=>$value) {
                    if ($key == 'status'){  
                    }
                    else{
                        if($value == 'ASC' || $value == 'DESC'){
                            $sql = '`' . $key . '` ' . $value;
                            array_push($filtersSQL, $sql);
                        }
                    }

                }
                $crimes = $DBConnection->prepare("SELECT `crime`.`id`, `crime`.`report_date`, `user`.`title`, `user`.`first_name`, `user`.`last_name`, `bike_image`.`image` , `bike`.`mpn`, `bike`.`brand`, `crime`.`crime_date`, `crime`.`status` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` INNER JOIN `user` ON `user`.id = `bike`.`user` INNER JOIN `bike_image` ON `bike`.`id` = `bike_image`.`bike` ORDER BY " . implode(', ', $filtersSQL) . " LIMIT ?, ?");
            }
            $crimes->bind_param('ii', $offset, $limit);
            $crimes->execute();
            $result = $crimes->get_result();
            $results = [];
            while($row = $result->fetch_assoc()){
                array_push($results, $row);
            }
            echo json_encode($results);

           


            
            
        }
    }


?>