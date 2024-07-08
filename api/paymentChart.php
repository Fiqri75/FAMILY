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
    include "./../utils/date.php";
    $sql = mysqli_query(
        $conn,
        "
            SELECT
                YEAR(placed_on) AS year,
                MONTH(placed_on) AS month,
                SUM(total_price) AS total_pending
            FROM
                orders
            WHERE
                payment_status = 'completed' AND
                YEAR(placed_on) = YEAR(CURDATE())
            GROUP BY
                YEAR(placed_on),
                MONTH(placed_on)
            ORDER BY
                year,
                month;
        ",
    );

    if ($sql->num_rows == 0) {
        echo json_encode([
            "message" => "Maaf data kosong!",
            "data" => []
        ]);
        return;
    }

    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $month_totals = array_fill_keys($months, 0);  // Using Indonesian month names as keys
    
    while ($row = mysqli_fetch_assoc($sql)) {
        $month = convertMonthNumberToIndonesian($row['month']);
        if (array_key_exists($month, $month_totals)) {
            $month_totals[$month] += $row['total_pending']; // Summing totals for the same month
        }
    }
    
    $data = array_values($month_totals);
    
    $datasets = [
        [
            'label' => 'Total Payment Completed '.date('Y'),
            'data' => $data,
            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1
        ]
    ];


    echo json_encode([
        "message" => "Berhasil!",
        "data" => [
            'chart' => [
                'labels' => $months,
                'datasets' => $datasets
            ]
        ]
    ]);
    return;
}

?>
