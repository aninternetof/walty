

<?php
   header("Content-Type: json", true);
   
   error_log($_POST['path']);
   error_log($_POST['tags']);
   
   $path = $_POST['path'];
   $tags = $_POST['tags'];
   $tags = json_decode($tags);
   
   //$tagsArray = array();
   //array_push($tagsArray, $tags);

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
   
   foreach($tags as $tag){
      $tag = strtolower($tag);
      $searchString = "INSERT INTO images(path, tag) VALUES('$path','$tag')";
      $status = $db->query($searchString);      
   }
   
   $searchString = "SELECT DISTINCT tag FROM images WHERE path = '$path'";
   $tagsResult = $db->query($searchString);
   $html = '';
   while($tag=$tagsResult->fetchArray()) {
         $html.= "<a href='#' onClick='removeTag(\"$path\", \"$tag[0]\")' class='button tiny round secondary tag' style='margin: 2px 2px 2px 0px'>$tag[0]</a>";
   } 
   $arr = array('html' => $html);
   echo json_encode($arr);      
   
   $db->close();
   
   




   
?>