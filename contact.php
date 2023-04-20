<?php
include 'conn.php';


  $name = preg_replace('/[[:space:]]+/', ' ', trim($_POST['name']));
  $email = preg_replace('/[[:space:]]+/', ' ', trim($_POST['email']));
  $phone= preg_replace('/[[:space:]]+/', ' ', trim($_POST['phone']));
  $message= preg_replace('/[[:space:]]+/', ' ', trim($_POST['message']));

  //Insert to db	
      $q = "INSERT INTO `contact`(`c_id`, `c_name`, `c_email`, `c_phone`, `c_message`, `c_created`)
      VALUES (NULL,'$name','$email','$phone','$message',Now() )";
  
   //echo $q;
     $objQuery = mysqli_query($db,$q);
   //$objResult = mysqli_fetch_array($objQuery);
  
  $message = "กรุญาติดต่อกลับ \n คุณ ".$name." \n email : ".$email." \n เบอร์โทร : ".$phone." \n".$message;
	$token = 'r4WEP6FbWVu3imIjodcYbN1wmVZCbvSEUkYXaczxgOt';
	send_line_notify($message, $token);	

   //LINE Notify
   function send_line_notify($message, $token){
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message");
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec( $ch );
    curl_close( $ch );

    return $result;
}

 header("Location: index.php?success=1");
?>
