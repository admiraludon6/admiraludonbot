<?php 

  include("./telegram_token.php");

  $update = json_decode(file_get_contents("php://input"), TRUE);

  if (isset($update)){
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    if (strpos($message, "/start") === 0) {
      $text = urlencode("Hi there !! , I'm Ahmad Miqdaad aka AdmiralUdon.\n\nBelow are the available command: \n\n /start , /vote , /love");
      file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$text);
    } else if (strpos($message, "/rate") === 0) {
      $keyboard = array(array("😀 Great !!","😐 Okay, I Guess","😕 Need Improvement"));
      $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
      $reply = json_encode($resp);
      $url = $path."/sendmessage?chat_id=".$chatId."&text=Choose&reply_markup=".$reply;
      file_get_contents($url);
    } else if (strpos($message, "/love") === 0) {
      $text = "I Love you too 😘 😘 😘 😘";
      file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$text);
    }
    else {
      $text = "Wrong command I guess";
      file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$text);
    }
  } else {
    echo "Welcome to AdmiralUdonBot !";
  }
?>