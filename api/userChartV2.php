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
                YEAR(created_at) AS year,
                MONTH(created_at) AS month,
                COUNT(*) AS total
            FROM
                users
            WHERE
                YEAR(created_at) = YEAR(CURDATE())
                AND user_type = 'user'
            GROUP BY
                YEAR(created_at),
                MONTH(created_at)
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
            $month_totals[$month] += $row['total']; // Summing totals for the same month
        }
    }
    
    $data = array_values($month_totals);
    
    $datasets = [
        [
            'label' => 'Total User '.date('Y'),
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
