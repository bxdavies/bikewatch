<div class="flex two">
    <div>
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
        <h3> Bike </h3>
        <div class="flex two center bike">
            <?php while ($bikeImage = $bikeImages->fetch_assoc()) { ?>
                <div>
                    <img class="stack" src="../../uploads/<?php echo $bikeImage['image'] ?>" onclick="imageModal(event)">
                </div>
            <?php } ?>
        </div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <b> Victim Bike Nickname: </b> <br>
                        <?php echo $bike['nickname'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> MPN: </b> <br>
                        <?php echo $bike['mpn'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Brand: </b> <br>
                        <?php echo $bike['brand'] ?>
                    </td>
                    <td>
                        <b> Model: </b> <br>
                        <?php echo $bike['model'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Type: </b><br>
                        <?php echo $bike['type'] ?>
                    </td>
                    <td>
                        <b> Wheel Size</b> <br>
                        <?php echo $bike['wheel_size'] ?>
                    </td>
                </tr>
                <tr>
                    <td id="bikeColor" style="color:  <?php echo $bike['colour'] ?>" value="<?php echo $bike['colour'] ?>">
                        <b> Color: </b> <br>
                    </td>
                    <td>
                        <b> Number of Gears: </b> <br>
                        <?php echo $bike['no_gears'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Brake Type:</b> <br>
                        <?php echo $bike['brake_type'] ?>
                    </td>
                    <td>
                        <b> Suspension: </b> <br>
                        <?php echo $bike['suspension'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Gender: </b> <br>
                        <?php echo $bike['gender'] ?>
                    </td>
                    <td>
                        <b> Age: </b> <br>
                        <?php echo $bike['age'] ?>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
