<?php

function isbooked($id, $type, $start_date, $end_date)
{
    require_once __DIR__ . "/../../database/connection.php";

    if ($type = "housing") {
        $db = connectDB();
        $req = $db->prepare("UPDATE disponibility SET is_booked = 1 WHERE id_housing = :id AND date >= :start_date AND date <= :end_date");

        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    } else {

        $db = connectDB();
        $req = $db->prepare("UPDATE disponibility SET is_booked = 1 WHERE id_performances = :id AND date >= :start_date AND date <= :end_date");

        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }
}


function addBooking($id, $type, $start_date, $end_date, $amount_people, $price, $userId, $title)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    if ($type == "performance") {
        $req = $db->prepare("INSERT INTO booking (performance_id,  start_date, end_date, amount_people, price, user_id, title) VALUES (:id, :start_date, :end_date, :amount_people, :price, :user_id, :title)");
        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'amount_people' => $amount_people,
            'price' => $price,
            'user_id' => $userId,
            'title' => $title
        ]);
        isbooked($id, $type, $start_date, $end_date);
    } else if ($type == "housing") {
        $req = $db->prepare("INSERT INTO booking (housing_id, start_date, end_date, amount_people, price, user_id, title) VALUES (:id,  :start_date, :end_date, :amount_people, :price, :user_id, :title)");
        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'amount_people' => $amount_people,
            'price' => $price,
            'user_id' => $userId,
            'title' => $title
        ]);

        isbooked($id, $type, $start_date, $end_date);

        
    }
}


function getBookingByUserId($userId, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../ads/adsInfo.php";

    $db = connectDB();

    if ($type == "traveler") {
        $req = $db->prepare("SELECT * FROM booking WHERE user_id = :userId");
        $req->execute(['userId' => $userId]);
        $bookings = $req->fetchAll();

        //Récupération de l'image de l'annonceen fonction de son type (si housing_id ou performance_id) grace a la fonction getAdsImages + addresse grace a la fonction getAdsAddress
        foreach ($bookings as $key => $booking) {
            if ($booking["housing_id"] != null) {

                if (!getAdsImages($booking["housing_id"], "housing")){
                    $bookings[$key]["image"] = NULL;
                
                }
                else{
                $bookings[$key]["image"] = getAdsImages($booking["housing_id"], "housing")[0];
                $bookings[$key]["address"] = getAdsAddress($booking["housing_id"], "housing");
                }
            } else if ($booking["performance_id"] != null) {

                if (!getAdsImages($booking["performance_id"], "performance")){
                    $bookings[$key]["image"] = NULL;
                
                }
                else{
                $bookings[$key]["image"] = getAdsImages($booking["performance_id"], "performance")[0];
                $bookings[$key]["address"] = getAdsAddress($booking["performance_id"], "performance");
                }
       
            }
        }


        return $bookings;
    
    } 
}
function addReview($rate, $comment, $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    $req = $db->prepare("UPDATE booking SET rate = :rate, review = :comment WHERE id = :id");
    $req->execute([
        'rate' => $rate,
        'comment' => $comment,
        'id' => $id
    ]);
    return "ok";
}

function getAllBookingByOwnerId($id){
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../ads/adsInfo.php";
    
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM booking b JOIN housing h ON b.housing_id = h.id WHERE h.id_user = :id");
    $req->execute(['id' => $id]);
    $bookings = $req->fetchALL();
    foreach ($bookings as $key => $booking) {
        if (!getAdsImages($booking["housing_id"], "housing")){
            $bookings[$key]["image"] = NULL;
        
        }
        else{
        $bookings[$key]["image"] = getAdsImages($booking["housing_id"], "housing")[0];
        $bookings[$key]["address"] = getAdsAddress($booking["housing_id"], "housing");
    }

}
    return $bookings;
} 


