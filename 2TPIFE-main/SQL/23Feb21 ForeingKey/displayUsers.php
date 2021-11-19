<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Display users</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <table>
        <tr>
            <th>Last name</th>
            <th>First name</th>
            <th>Age</th>
            <th>Username</th>
            <th>Password</th>
            <th>Country</th>
        </tr>
        <?php
            include_once("dbConnect.php");
            $sqlSelect=$connection->prepare("SELECT * from ppl left join countries on ppl.ID_COUNTRY = countries.ID_COUNTRY");
            if(!$sqlSelect){
                die("Error in the sql select");
            }
            $succeeded = $sqlSelect->execute();
            if(!$succeeded){
                die("Something went wrong when executing the query");
            }
            $result = $sqlSelect->get_result();
        ?>
    </table>
</body>
</html>