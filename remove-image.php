

<?php
   header("Content-Type: json", true);
   
   error_log($_POST['path']);
   
   $path = $_POST['path'];

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('db/images.db');
      }
   }
   $db = new MyDB();
      
   if(!$db){
      echo $db->lastErrorMsg();
   }
   
   $searchString = "DELETE FROM images WHERE path = '$path'";
   $status = $db->query($searchString);
   
   unlink($path);
   
   $html = 'Success';
   $arr = array('html' => $html);
   echo json_encode($arr);      
   
   $db->close();




   
?>