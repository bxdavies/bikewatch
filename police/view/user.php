<div class="flex two">
    <div class>
        <h3> User </h3>
        <table>
            <tbody>
                <tr>
                    <td>
                        <b> Full Name </b> <br>
                        <h3> <?php echo $user['title'] . ' ' . $user['first_name'] . ' ' . $user['last_name'] ?> </h3>
                    </td>
                    <td>
                        <b> Gender: </b> <br>
                        <?php echo $user['gender'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Date of Bike: </b> <br>
                        <?php echo $user['dob'] ?>
                    </td>
                    <td>
                        <b> Ethnicity: </b> <br>
                        <?php echo $user['ethnicity'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b> Address: </b> <br>
                        <?php
                        echo $user['address_line_1'] . "<br>";
                        if ($user['address_line_2'] != '') {
                            echo $user['address_line_2'] . "<br>";
                        }
                        echo $user['town'] . "<br>";
                        echo $user['local_authority'] . "<br>";
                        echo $user['POSTcode'] . "<br>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Email Address: </b> <br>
                        <?php echo $user['email_address'] ?>
                    </td>
                    <td>
                        <b> Mobile Number: </b> <br>
                        <?php echo $user['mobile_number'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h3> Bikes </h3>
        <table>
            <thead>
                <tr>
                    <th> Image </th>
                    <th> Nickname </th>
                    <th class="details"> Details </th>
                    <th> Actions </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($bike = $bikes->fetch_assoc()) {

                ?>
                        <tr>
                            <td> <img src="<?php echo $uploadFolder . $bike['image']; ?>" class="bike-image"> </td>
                            <td> <?php echo $bike['nickname']; ?> </td>
                            <td class="details">
                                <p> MPN: <?php echo $bike['mpn']; ?> </p>
                                <p> Brand: <?php echo $bike['brand']; ?> </p>
                            </td>
                            <td>
                                <a href="view.php?type=bike&id=<?php echo $bike['id'] ?>" class="button"> More Details </a>
                              
                            </td>
                        </tr>

                <?php } ?>
                
            </tbody>
        </table>
    </div>
</div>