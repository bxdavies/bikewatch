<div class="alert-container" id="alert-container">
<?php

    // If alert array is not empty then loop through array 
    if(count($alerts) > 0)
    {   
        // Loop through alert array
        foreach ($alerts as $alert){

            // Echo HTML using array values
            echo <<<EOL
            <div class="alert $alert[0]" hover="false">
                <p> $alert[1]<span class="alert-close" redirecturl=$alert[2]>&times;</span></p>
                <progress class="alert-progress" value="0" max="100"></progress>
            </div>
            EOL;
        }
       
    }
?>
</div>