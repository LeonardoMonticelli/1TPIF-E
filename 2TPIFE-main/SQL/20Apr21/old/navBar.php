<!DOCTYPE html>
 <html>
 <head>
    <style>
        .topnav {
        background-color: #333;
        overflow: hidden;
        }

        .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        .topnav :hover {
        background-color: #ddd;
        color: black;
        }

        .topnav :active {
        background-color: rgb(80, 157, 209);
        color: white;
        }
    </style>
 </head>
 <body>
   <?php
      include_once "dbConnect.php";
      $pages = array();
      $pages["signup.php"] = "Signup";
      $pages["login.php"] = "Login";
      if($_SESSION["isUserLoggedIn"]){
         $pages["addCountry.php"] = "Add a country";
         $pages["addProducts.php"] = "Add a product";
         $pages["viewProducts.php"] = "View products";
      } 
   ?>     
   <div class="topnav">
      <?php foreach($pages as $url=>$title){?>
         <a href="<?=$url?>">
            <?=$title?>
         </a>
      <?php }?>
   </div>
 </body>
 </html>