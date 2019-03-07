<?php

/**
 * This PHP file reads the pixels of an image file. The code uses .PNG and uploaded file in its first version.
 * Main goals for the next steps:
 * - Create a simple file manager and control panel which is able to upload and pick files from a folder
 *   and set the parameters for processing (scale, measuring unit, etc.)
 * - Make this file to be able to communicate with other files (with $_FILES superglobal for instance)
 * - Adding new, useful features (this is a further goal)
 *
 */

    $bmp = imagecreatefrompng("tank_hmap_08.png"); //in first version we had to use .png instead of .bmp (due to host issues)
    $width = imagesx($bmp);
    $height = imagesy($bmp);
    $min = 999;
    $max = 0;
    $px1 = array(); //$px1 is a 'pseudo-matrix'

/*in this for cycle bellow we create an array of the pixels' colorcodes
on the other hand we search for the min and max values too*/
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $pont = hexdec(substr(dechex(imagecolorat($bmp, $x, $y)), 4));
            //$pont: last two hex digit of a pixel's color code converted to dec
            array_push($px1, $pont);
            echo "$pont "; //print these values because of selfchecking - not necessary later

            //searching for min:
            if ($min >= $pont) {
                $min = $pont;
            }

            //searching for max:
            if ($max <= $pont) {
                $max = $pont;
            }
        }
        echo "<br>";
    }

    echo "<br><br>";
    echo "$min <br>";
    echo "$max <br>";
    echo "<br><br>";

    $px2 = array(); //an other pseudo-array - this time for the final values
    $leptek = 640/($max - $min); //$leptek: exact differance in height between two adjacent colorcode-values

    /*in the following for cycle we print height datas in a table
    it also colors the cells with the original pixel-colors because illustrating reasons*/
    echo '<table>';
    for ($y = 0; $y < $height; $y++) {
        echo "<tr>";
        for ($x = 0; $x < $width; $x++) {
            $pre_pontmm = hexdec(substr(dechex(imagecolorat($bmp, $x, $y)), 4));
            $cella = dechex(imagecolorat($bmp, $x, $y));
            $pontmm = round(($pre_pontmm - $min) * $leptek); //variable refers to mm as a unit but it shouldn't be the only usable one later!
            array_push($px2, $pontmm); ?>
            <td bgcolor="#<?php echo $cella; ?>"><?php echo $pontmm; ?></td> <?php
        }
        echo "</tr>";
    }
    echo "</table>";
