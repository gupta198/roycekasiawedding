<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $servername = "localhost";
    $username = "root";
    $password = "root";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=wedding", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id FROM invites WHERE password = '$request->password';";
        $result = $conn->query($sql);
        $return = $result->fetch();
        if (count($return) == 0) {
            echo json_encode(false);
            return;
        }
        $inviteId = $return[0];
        $sql = "UPDATE invites SET email='$request->email', attending1=$request->attending1, attending2=$request->attending2 WHERE id=$inviteId;";
        $conn->query($sql);
        $sql = "DELETE FROM guests WHERE inviteId=$inviteId;";
        $conn->query($sql);
        $sql = "INSERT INTO guests (inviteId, firstName, lastName) VALUES ($inviteId, '$name->first', '$name->last');";
        foreach($request->kidArray as $name) {
            if ($name->first == "" || $name->last == "") continue;
            $sql = "INSERT INTO guests (inviteId, firstName, lastName) VALUES ($inviteId, '$name->first', '$name->last');";
            // $sql->bindParam(':invite', $inviteId, PDO::PARAM_INT);
            // $sql->bindParam(':first', $name->first, PDO::PARAM_STR);
            // $sql->bindParam(':last', $name->last, PDO::PARAM_STR);
            // $sql->execute(array(':invite' => $inviteId,
                                // ':first' => $name->first,
                                // ':last' => $name->last));

            $conn->query($sql);
        }
        //echo json_encode(true);
        $conn = null; 
      } catch(PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
        echo json_encode(false);
      }    
?>