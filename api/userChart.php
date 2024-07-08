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
    $sql = mysqli_query(
        $conn,
        "
            SELECT user_type, COUNT(*) as user_count
            FROM users
            WHERE user_type = 'user'
            GROUP BY user_type;
        ",
    );

    if ($sql->num_rows == 0) {
        echo json_encode([
            "message" => "Maaf Data kosong!",
            "data" => []
        ]);
        return;
    }


    $labels = [];
    $data = [];
    $backgroundColor = [];
    $borderColor = [];
    
    // Colors for the chart elements, these can be static or dynamically generated
    $colorSet = [
        'rgba(255, 99, 132, 0.2)', // Red
        'rgba(54, 162, 235, 0.2)', // Blue
        'rgba(255, 206, 86, 0.2)', // Yellow
        'rgba(75, 192, 192, 0.2)', // Green
        'rgba(153, 102, 255, 0.2)', // Purple
        'rgba(255, 159, 64, 0.2)'  // Orange
    ];
    
    $index = 0;
    
    // Fetch each row and prepare data for the chart
    while ($row = mysqli_fetch_assoc($sql)) {
        $labels[] = $row['user_type'];
        $data[] = $row['user_count'];
        $color = $colorSet[$index % count($colorSet)]; // Cycle through colors and repeat if necessary
        $backgroundColor[] = $color;
        $borderColor[] = str_replace('0.2', '1', $color); // Use a more opaque version of the color for the border
        $index++;
    }
    
    $datasets = [
        [
            'label' => 'Total User',
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
