<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $servername = "localhost";
    $username = "root";
    $password = "root";
    if (strcmp($request->password, "snack") == 0) {
      echo json_encode("unlocked");
      return;
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=wedding", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM invites WHERE password = '$request->password';";
        $result = $conn->query($sql);
        $return = $result->fetch();
        if (count($return) == 0) {
            echo json_encode(false);
            return;
        }
        $sql = "SELECT firstName as first, lastName as last FROM guests WHERE inviteId = $return[0];";
        //echo $sql;
        $result = $conn->query($sql);
        for ($i = 0; $kid = $result->fetch(); $i++) {
          $return['kidArray'][$i] = $kid;
        }
        
        echo json_encode($return);
        $conn = null; 
      } catch(PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
        echo json_encode(false);
      }    
?>