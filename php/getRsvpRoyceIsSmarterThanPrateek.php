<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $servername = "localhost";
    $username = "root";
    $password = "root";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=wedding", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM guest_view;";
        $result = $conn->query($sql);
        echo "<table>";
        echo "<tr><td>FirstName1</td> <td>LastName1</td> <td>FirstName2</td> <td>LastName2</td> <td>email</td> <td>Attending1</td> <td>Attending2</td> <td>KidFirstName</td> <td>KidLastName</td></tr>";
        while ($return = $result->fetch()) {
            echo "<tr>";
            for ($i=0;$i<9;$i++)
            echo "<td>$return[$i]</td>";
            echo "</tr>";
        }
        echo "</table>";

        if (count($return) == 0) {
            echo json_encode(false);
            return;
        }
        $conn = null; 
      } catch(PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
        echo json_encode(false);
      }    
?>