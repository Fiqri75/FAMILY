<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom admin css file link -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .messages {
            height: 280px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .user-message {
            background-color: #f1f1f1;
            text-align: right;
        }
        .bot-response {
            background-color: #d1e7dd;
        }
    </style>
</head>
<body>

<!-- <#?php @include 'header.php'; ?> -->
<?php @include 'chatbot_header.php'; ?>

<!-- <section class="heading">
    <h3>Chatbot</h3>
    <p> <a href="home.php">Home</a> / Chat </p>
</section> -->

<section style="padding:0; margin:0; max-width:100%">
<div class="chatbox">
    <div class="messages" id="messageContainer">
        <!-- Messages will be appended here -->
    </div>
    <div class="wrapper-input-chat">
       <input type="text" id="messageInput" class="inputchat" placeholder="Type a message...">
       <button class="buttonchat" onclick="sendMessage()">Send</button>
    </div>
   </div>

</section>

<!-- <#?php @include 'footer.php'; ?> -->

<script src="js/script.js"></script>
<script>
   //  let isSender = true;

    function sendMessage() {
        const messageContainer = document.getElementById('messageContainer');
        const messageInput = document.getElementById('messageInput');
        if (messageInput.value.trim() !== '') {


            // if (isSender) {
            //     newMessage.classList.add('sender');
            // } else {
            //     newMessage.classList.add('receiver');
            // }
            const newMessageSender = document.createElement('div');
               newMessageSender.textContent = messageInput.value;
               newMessageSender.classList.add('message1');
               newMessageSender.classList.add('sender1');
               messageContainer.appendChild(newMessageSender);
            fetch('<?=$baseUrl?>LLM/groq.php', { // Replace with your actual API endpoint
               method: 'POST',
               headers: {
                     'Content-Type': 'application/json',
               },
               body: JSON.stringify({ message: messageInput.value })
            })
            .then(response => {
                console.log(response)
                return response.json()
            }) // Assuming the server responds with JSON
            .then(data => {
               const newMessageReceiver = document.createElement('div');
               newMessageReceiver.innerHTML = data;
               newMessageReceiver.classList.add('message1');
               newMessageReceiver.classList.add('receiver1');
               messageContainer.appendChild(newMessageReceiver);
            })
            .catch((error) => {
               console.error('Error:', error);
               alert('Failed to send message');
            });

            
            messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to the bottom
            messageInput.value = ''; // Clear input field
        }
    }
</script>

</body>
</html>
