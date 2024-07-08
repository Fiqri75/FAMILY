<?php
session_start();
if (file_exists("./../config.php")) {
    
include "./../config.php";
} else {
    die('tidak');
}


header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
  case 'GET':
    try {
        handleGetRequest();
    } catch (\Throwable $th) {
        echo json_encode([
            "message" => $th->getMessage(),
            "data" => []
        ]);
        return;
    }
    break;
  case 'POST':
    break;
  case 'PUT':
    break;
  case 'DELETE':
    break;
  default:
    echo json_encode(["message" => "Method not supported"]);
}

function handleGetRequest() {
    include "./../config.php";
    $sql1 = mysqli_query(
        $conn,
        "
            SELECT COUNT(*) as total, o.user_id FROM `orders` o 
            WHERE CURRENT_TIMESTAMP <= o.expired_at AND o.payment_status = 'completed'
            GROUP BY o.user_id;
        ",
    );

    $number_of_users_premium = 0;
    if(mysqli_num_rows($sql1) > 0){
        while($fetch1 = mysqli_fetch_assoc($sql1)){
           $number_of_users_premium = $fetch1['total'];
        }
     }

    $sql2 = mysqli_query(
        $conn,
        "
           SELECT COUNT(*) as total FROM `users` WHERE user_type = 'user';
        ",
    );

    $number_of_users = 0;
    if(mysqli_num_rows($sql2) > 0){
        while($fetch2 = mysqli_fetch_assoc($sql2)){
           $number_of_users = $fetch2['total'];
        }
     }





    $labels = ['Non Premium', 'Premium'];
    $data = [
        $number_of_users - $number_of_users_premium,
        $number_of_users_premium,
    ];
    $backgroundColor = [
        'rgba(255, 99, 132, 0.2)', // Red
        'rgba(54, 162, 235, 0.2)', // Blue
    ];
    $borderColor = [
        'rgba(255, 99, 132, 1)', // Red
        'rgba(54, 162, 235, 1)', // Blue
    ];

    


    $datasets = [
        [
            'label' => 'User Type Count',
            'data' => $data,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
            'borderWidth' => 1
        ]
    ];

    echo json_encode([
        "message" => "Berhasil!",
        "data" => [
            'chart' => [
                'labels' => $labels,
                'datasets' => $datasets
            ]
        ]
    ]);
    return;
}

?>
