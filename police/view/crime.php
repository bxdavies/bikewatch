<div class="flex two">
    <div>
        <h3> Victim </h3>
        <table>
            <tbody>
                <tr>
                    <td>
                        <b> Full Name </b> <br>
                        <h3> <?php echo $victim['title'] . ' ' . $victim['first_name'] . ' ' . $victim['last_name'] ?> </h3>
                    </td>
                    <td>
                        <b> Gender: </b> <br>
                        <?php echo $victim['gender'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Date of Bike: </b> <br>
                        <?php echo $victim['dob'] ?>
                    </td>
                    <td>
                        <b> Ethnicity: </b> <br>
                        <?php echo $victim['ethnicity'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b> Address: </b> <br>
                        <?php
                        echo $victim['address_line_1'] . "<br>";
                        if ($victim['address_line_2'] != '') {
                            echo $victim['address_line_2'] . "<br>";
                        }
                        echo $victim['town'] . "<br>";
                        echo $victim['local_authority'] . "<br>";
                        echo $victim['POSTcode'] . "<br>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Email Address: </b> <br>
                        <?php echo $victim['email_address'] ?>
                    </td>
                    <td>
                        <b> Mobile Number: </b> <br>
                        <?php echo $victim['mobile_number'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h3> Bike </h3>
        <div class="flex two center">
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
<!-- Crime Details -->
<div class="flex one center crime">
    <div>
        <h3> Crime Details</h3>
        <table>
            <tbody>
                <tr>
                    <td>
                        <b> Report Date: </b> <br>
                        <?php echo $crime['report_date'] ?>
                    </td>
                    <td>
                        <b> Last Seen Date: </b> <br>
                        <?php echo $crime['crime_date'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Last Seen Address: </b> <br>
                        <?php
                        echo $crime['address_line_1'] . "<br>";
                        if ($crime['address_line_2'] != '') {
                            echo $crime['address_line_2'] . "<br>";
                        }
                        echo $crime['town'] . "<br>";
                        echo $crime['local_authority'] . "<br>";
                        echo $crime['POSTcode'] . "<br>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Status: </b> <br>
                        <?php echo $crime['status'] ?>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

<!-- Add Comments -->
<div class="flex one center crime">
    <div>
        <h3> Comments </h3>

        <form method="POST">
            <label>
                <input type="checkbox" name="visibility">
                <span class="checkable"> Available to Victim? </span>
            </label>
            <br>
            <br>
            <label for="comment"> Comment </label>
            <textarea name="comment" id="comment" placeholder="My comment text here" required></textarea>
            <input type="submit" value="Save" name="save" />
        </form>

        <div class="comments-container">
            <?php while ($comment = $comments->fetch_assoc()) { ?>


                    <div>
                        <article class="card">
                            <header>
                                <?php
                                if ($comment['role'] == 'user') {
                                    echo "<i class='ri-user-line'></i>";
                                } else if ($comment['role'] == 'police') {
                                    echo "<i class='ri-user-line police'></i>";
                                }
                                ?>
                                <?php echo $comment['title'] . ' ' . $comment['first_name'] . ' ' . $comment['last_name'] ?>
                                <i class="role"> <?php echo $comment['role']; ?> </i>
                            </header>
                            <section>
                                <?php echo $comment['comment']; ?>
                            </section>
                            <footer>
                                <button> Reply</button>
                            </footer>
                        </article>
                    </div>
            <?php } ?>

        </div>
    </div>
</div>