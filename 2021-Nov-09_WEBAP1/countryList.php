<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Country List</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='loadCities.js'></script>
</head>
<body>
    <?php
        $servername="localhost";
        $username="root";
        $password="";
        $db="firstajax";
    
        $conn = new mysqli($servername, $username, $password, "firstajax");
    
        //Check connection 
        if($conn->connect_error){
            die("Connection failed: ". $conn->connect_error);
        }
    
        $stmt = $conn->prepare("SELECT * from countries");
    
        $stmt->execute();
        $res=$stmt->get_result();
        // print("This is a list of all known cities");
        print("<br>");
        print("<select id='Country'>");
        while($row = $res->fetch_assoc()){
            ?>
            <option value="<?= $row["CountryID"] ?>"><?= $row["CountryName"]?></option>
            <?php
        }
        print("</select>");
    
        $stmt->close();
    ?>
    <div id="cities"></div>
</body>
</html>