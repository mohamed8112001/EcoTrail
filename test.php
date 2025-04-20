<?php
      require('config.php');
      if($_SERVER['REQUEST_METHOD']='post'){
        $name = $_POST['name'];
      }
      echo $name;
      ?>