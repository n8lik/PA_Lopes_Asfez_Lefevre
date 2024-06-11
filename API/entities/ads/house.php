<?php

require_once __DIR__ . "/../../database/connection.php";


function insertHousing($title,$description, $experienceType, $id_user, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $fee,$propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time, $wifi , $parking, $pool, $tele, $oven, $air_conditionning ,$wash_machine, $gym ,$kitchen)
{
    $db = connectDB();

    $queryprepare = $db->prepare("INSERT INTO housing (title, description, id_user, management_type, address, city, postal_code, country, fee, type_house, type_location, amount_room, guest_capacity, property_area, price, contact_phone, contact_time, wifi, parking, pool, tele, oven, air_conditionning, wash_machine, gym, kitchen) VALUES (:title, :description, :id_user, :management_type, :address, :city, :postal_code, :country, :fee, :type_house, :type_location, :amount_room, :guest_capacity, :property_area, :price, :contact_phone, :contact_time, :wifi, :parking, :pool, :tele, :oven, :air_conditionning, :wash_machine, :gym, :kitchen)");
    $queryprepare->execute([
        'title' => $title,
        'description' => $description,
        'id_user' => $id_user,
        'management_type' => $experienceType,
        'address' => $propertyAddress,
        'city' => $propertyCity,
        'postal_code' => $propertyZip,
        'country' => $propertyCountry,
        'fee' => $fee,
        'type_house' => $propertyType,
        'type_location' => $rentalType,
        'amount_room' => $bedroomCount,
        'guest_capacity' => $guestCapacity,
        'property_area' => $propertyArea,
        'price' => $price,
        'contact_phone' => $contactPhone,
        'contact_time' => $time,
        'wifi' => $wifi,
        'parking' => $parking,
        'pool' => $pool,
        'tele' => $tele,
        'oven' => $oven,
        'air_conditionning' => $air_conditionning,
        'wash_machine' => $wash_machine,
        'gym' => $gym,
        'kitchen' => $kitchen
    ]);
    $lastId = $db->lastInsertId();
    
    return $lastId;

}

