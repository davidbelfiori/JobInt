<?php

//fetchdata.php
if (isset($_POST["action"])) {
    $conn = mysqli_connect("localhost", "root", "root", "jobint");
    $output = '';
    if ($_POST["action"] == "Area_professionale") {
        $query = "SELECT sotto_area FROM jobint.categoriaprofessionale WHERE area = '".$_POST["query"]."' GROUP BY sotto_area";
        $result = mysqli_query($conn, $query);
        $output .= '<option value="">Select Sotto area</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="'.$row["sotto_area"].'">'.$row["sotto_area"].'</option>';
        }
    }
    if ($_POST["action"] == "Sotto_area_professionale") {
        $query = "SELECT categoria FROM jobint.categoriaprofessionale WHERE sotto_area= '".$_POST["query"]."'";
        $result = mysqli_query($conn, $query);
        $output .= '<option value="">Select categoria</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="'.$row["categoria"].'">'.$row["categoria"].'</option>';
        }
    }
    echo $output;
}
