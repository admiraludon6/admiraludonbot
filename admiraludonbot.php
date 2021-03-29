<?php 

  include("./telegram_token.php");

  $update = json_decode(file_get_contents("php://input"), TRUE);


  // Check if callback is set
  if (isset($update['callback_query'])) {

    // Reply with callback_query data
    $data = http_build_query([
        'text' => 'Selected choice: ' . $update['callback_query']['data'],
        'chat_id' => $update['callback_query']['from']['id']
    ]);
    file_get_contents($path . "/sendMessage?{$data}");
  }

  // Normal query
  if (isset($update)){
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    if (strpos($message, "/start") === 0) {
      $text = urlencode("Hi there !! , I'm Ahmad Miqdaad aka AdmiralUdon.\n\nBelow are the available command: \n\n/start , /rate , /choose , /hire , /love");
      file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$text);
    } else if (strpos($message, "/rate") === 0) {
      $keyboard = array(array("😍","😀","😐","😑","🙁"));
      $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
      $reply = json_encode($resp);
      $url = $path."/sendmessage?chat_id=".$chatId."&text=Choose&reply_markup=".$reply;
      file_get_contents($url);
    } else if (strpos($message, "😍") === 0 || strpos($message, "😀") === 0 || strpos($message, "😐") === 0 || strpos($message, "😐") === 0 || strpos($message, "🙁") === 0) {
      $text = "Thank You for your rating 🙇‍♂️🙇‍♂️🙇‍♂️";
      file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$text);
    } else if (strpos($message, "/choose") === 0) {
      $options=array(
                array("text" => "Choose A", "callback_data" => "A"), 
                array("text" => "Choose B", "callback_data" => "B"),
                array("text" => "Choose C", "callback_data" => "C")
              );
      $keyboard = array($options);
      $resp = array("inline_keyboard" => $keyboard);
      $reply = json_encode($resp,true);
      $url = $path."/sendmessage?chat_id=".$chatId."&text=Choose&parse_mode=HTML&reply_markup=".$reply;
      file_get_contents($url);
    } else if (strpos($message, "/hire") === 0) {

      $options=array(
        array(
          "text" => "Click for link",
          "url" => "https://admiraludon.com"
        )
      );
      $keyboard = array($options);
      $resp = array("inline_keyboard" => $keyboard);
      $reply = json_encode($resp,true);
      $url = $path."/sendPhoto?chat_id=".$chatId."&reply_markup=".$reply;

      $post_fields = array('chat_id'   => $chat_id,
      'photo'     => new CURLFile(realpath("/home/arcutrac/admiraludon.com/images/software.jpg"))
      );    
      
      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type:multipart/form-data"
      ));
      curl_setopt($ch, CURLOPT_URL, $url); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
      $output = curl_exec($ch);

    }
    else if (strpos($message, "/love") === 0) {
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