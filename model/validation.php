<?php

function validName($name) {
    $name = str_replace(' ', '', $name);
    return !empty($name) && ctype_alpha($name);
}

function validAge($age) {
    return !is_nan((floatval($age))) && $age >= 18 && $age <= 118;
}
function validPhone($phone) {

    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

    $phone_to_check = str_replace("-", "", $filtered_phone_number);


    if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
        return false;
    } else {
        return true;
    }
}
function validEmail($email) {
    return (!preg_match(
        "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
        ? FALSE : TRUE;
}

function validOutdoor($outdoor) {
    $outdoors = getOutDoor();
    if(empty($outdoor)) {
        return false;
    }

    foreach($outdoor as $key) {
        if(in_array($key, $outdoors)) {
            return true;
        }
    }
    return false;
}

function validIndoor($indoor) {
    $indoors = getInDoor();
    if(empty($indoor)) {
        return false;
    }

    foreach($indoor as $key) {
        if(in_array($key, $indoors)) {
            return true;
        }
    }
    return false;
}
