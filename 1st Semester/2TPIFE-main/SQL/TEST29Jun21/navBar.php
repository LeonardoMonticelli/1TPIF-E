<!DOCTYPE html>
 <html>
 <head>
    <style>
        .topnav {
         background-color: #333;
         overflow: hidden;
        }

        .topnav a{
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

        .topnav input {
         float: right;
         border: none;
         float: left;
         color: #f2f2f2;
         text-align: center;
         padding: 14px 16px;
         text-decoration: none;
         font-size: 17px;
        }
    </style>
 </head>
 <body>
   <?php
      include_once "dbConnect.php";
      if(!isset($_SESSION["userLoggedIn"])){
         $_SESSION["userLoggedIn"] = false;
      }

      if(isset($_POST["logout"])){
         session_unset();
         session_destroy();
         $_SESSION["userLoggedIn"] = false;
         header("Location: login.php");
      }

      $pages = array();
      if($_SESSION['userLoggedIn']) {
         $pages["shop.php"] = "The shop";
         $pages["shoppingCart.php"] = "Checkout: ".sizeof($_SESSION["shoppingCart"])." items";
      }
   ?>     
   <div class="topnav">
      <?php foreach($pages as $url=>$title){?>
         <a href="<?=$url?>">
            <?=$title?>
         </a>
      <?php }?>
      <?php if($_SESSION["userLoggedIn"]){?>
      <form method="POST">
         <input class="topnav" type="submit" value="Logout" name="logout">
      </form>
      <!-- <form method="post">
         <input class="topnav" type="submit" value="Empty the cart" name="clearCart">
      </form> -->
      <?php }?>
   </div>
 </body>
 </html>