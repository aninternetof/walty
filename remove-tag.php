

<?php
   header("Content-Type: json", true);
   
   error_log($_POST['path']);
   error_log($_POST['tag']);
   
   $path = $_POST['path'];
   $tag = $_POST['tag'];

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
   
   $searchString = "DELETE FROM images WHERE path = '$path' AND tag = '$tag'";
   $status = $db->query($searchString);
   
   
   $searchString = "SELECT DISTINCT tag FROM images WHERE path = '$path'";
   $tagsResult = $db->query($searchString);
   $html = '';
   while($tag=$tagsResult->fetchArray()) {
         $html.= "<a href='#/' onClick='removeTag(\"$path\", \"$tag[0]\")' class='button tiny round secondary' style='margin: 2px 2px 2px 0px'>$tag[0]</a>";
   } 
   $arr = array('html' => $html);
   echo json_encode($arr);      
   
   $db->close();




   
?>