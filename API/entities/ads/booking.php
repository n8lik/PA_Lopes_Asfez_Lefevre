<?php



function addBooking($id, $type, $start_date, $end_date, $amount_people, $price, $userId, $title)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    if ($type == "performance"){
        $req = $db->prepare("INSERT INTO booking (performance_id,  start_date, end_date, amount_people, price, user_id, title) VALUES (:id,:start_date, :end_date, :amount_people, :price, :user_id, :title)");
        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'amount_people' => $amount_people,
            'price' => $price,
            'user_id' => $userId,
            'title' => $title
        ]);
    } else if ($type == "housing"){
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
    }

    
}
