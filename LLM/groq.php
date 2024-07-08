<?php
require __DIR__ . '/vendor/autoload.php';
use LucianoTonet\GroqPHP\Groq;
session_start();
if (file_exists("./../config.php")) {
    
include "./../config.php";
} else {
    die('tidak');
}
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

function tokenize($text) {
    $text = strtolower($text); // Konversi ke huruf kecil
    $words = preg_split('/\s+/', $text); // Pecah menjadi kata-kata
    return $words;
}



header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    handleGetRequest();
    break;
  case 'POST':
    try {
        handlePostRequest();
    } catch (\Throwable $th) {
        return json_encode([
            "message" => $th->getMessage(),
            "data" => []
        ]);
    }
    break;
  case 'PUT':
    handlePutRequest();
    break;
  case 'DELETE':
    handleDeleteRequest();
    break;
  default:
    echo json_encode(["message" => "Method not supported"]);
}

function handleGetRequest() {
    return generateResponse($_GET['message']);
}

function handlePostRequest() {
    $json = file_get_contents("php://input");
    $data =json_decode($json, true);
    if(isset($data['message'])){
        return generateResponse($data['message']);
    }

    echo json_encode("Maaf sepertinya gagal terhubung!");
}

function handlePutRequest() {
  echo json_encode(["message" => "Handling PUT Request"]);
}

function handleDeleteRequest() {
  echo json_encode(["message" => "Handling DELETE Request"]);
}


function generateResponse($message) {
    $apiKey = getenv('GROQ_API_KEY');
    header("Content-Type: application/json");
    include "./../config.php";
    try {
        
        
        $startMessage = [
           
            [
                'role'    => 'system',
                'content' => 'Kamu adalah asisten yang membantu pengguna dalam bahasa Indonesia. Hanya menjawab sapaan dan seputaran parenting atau psikologi. Jika pertanyaan user melenceng dari topik, cukup balas dengan Mohon Maaf Saya Tidak Dapat Menjawab.'
            ],
            [
                'role'    => 'system',
                'content' => '`Ini database baru anda. Tolong disimpan. untuk user mengatasi keluhan.`'
            ],
           
        ];
        $endMessage =  [[
            'role'=>'system',
            'content' => ''
        ],
        [
            'role'    => 'user',
            'content' => isset($message) ? $message : 'Perkenalkan anda'
        ]];

        $tokens = tokenize($message);
        $searchTerm = '%' . implode('%', $tokens) . '%';
        $groq = new Groq($apiKey);
        $sql = mysqli_query($conn,"SELECT keluhan, cara_mengatasi FROM solving WHERE keluhan LIKE '$searchTerm' OR cara_mengatasi LIKE '$searchTerm'");
        if ($sql->num_rows > 0) {
            // output data of each row
            $dbKnowledge = [];
            $idx = 1;
            while($row = mysqli_fetch_assoc($sql)) {
                $keluhan = $row['keluhan'];
                $caramengatasi = $row['cara_mengatasi'];
                array_push(
                    $dbKnowledge,
                    [
                        'role' => 'system',
                        'content' => "Pengetahuan $idx: yaitu Keluhan: $keluhan. Jawaban: $caramengatasi"
                    ]
                );
                $idx++;
            }
            $chatCompletion = $groq->chat()->completions()->create([
                'model'    => 'mixtral-8x7b-32768', // Ensure this model ID is correct
                'messages' =>   array_merge(
                    $startMessage,
                    $dbKnowledge,
                    $endMessage
                )
            ]);
        
            echo json_encode($chatCompletion['choices'][0]['message']['content']);
        } else {
            $chatCompletion = $groq->chat()->completions()->create([
                'model'    => 'mixtral-8x7b-32768', // Ensure this model ID is correct
                'messages' =>   [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten yang ahli parenting dalam bahasa Indonesia. Hanya menjawab seputaran parenting atau psikologi saja, tapi membalas sapaan jika pertanyaan user melenceng dari topik, cukup balas dengan Mohon Maaf Saya Tidak Dapat Menjawab.'
                    ],
                    [
                        'role'    => 'user',
                        'content' => isset($message) ? $message : 'Perkenalkan anda'
                    ]
                ]
            ]);
            echo json_encode($chatCompletion['choices'][0]['message']['content']);
        }
       
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
