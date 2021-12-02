<?php

if (isset($_FILES['file']['name'])) {

    $filename = $_FILES['file']['name'];

    $location = $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    $valid_extensions = ['csv', 'txt'];

    $cdate = (new DateTime())->format('Y-m-d-H-i-s');
    $response = 0;
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], 'upl_' . $cdate . '.' . $imageFileType)) {
            $response = 'upl_' . $cdate . '.' . $imageFileType;
        }
    }

    echo $response;
    exit;
}