

<?php
   header("Content-Type: json", true);
   
   $postData = $_POST["tags"];
   $searchTags = json_decode($postData);
   $html = "";

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
   
   $searchString = "SELECT DISTINCT path FROM images";
   if (count($searchTags))
      $searchString.=' WHERE ';
   foreach ($searchTags as $tag) {
      $tag = strtolower($tag);
      $searchString.="tag = '$tag' OR ";
   }
   $searchString = chop($searchString, ' OR ');
   
   error_log($searchString);
   $pathsResult = $db->query($searchString);
   
   $paths = array();
   while($path=$pathsResult->fetchArray()) {
      array_push($paths, $path);
   }   
   
   
  $html.= "<div class='row'>";  

  for($i=0; $i<count($paths); $i++) {
      $p = $paths[$i][0];
      $divClass = 'small-4 columns';
      if ($i==count($paths)-1)
         $divClass.=' end';
      $html.= "<div class='$divClass'><div class='panel'><a href='#' onClick='viewPhoto(\"$p\")'><img  src=\"$p\" width='600px' style='margin-bottom:10px'></a>";
      $tags = $db->query("SELECT tag FROM images WHERE path = '$p'");
      while($tag=$tags->fetchArray()) {
         if (in_array($tag[0], $searchTags))
            $html.= "<div class='button tiny round success' style='margin: 2px 2px 2px 0px'>$tag[0]</div>";
         else
            $html.= "<div class='button tiny round secondary' style='margin: 2px 2px 2px 0px'>$tag[0]</div>";
      }
      $html.= "</div></div>";

   }   
   
   $html.= "</div>";
   
   $arr = array('html' => $html);

   echo json_encode($arr);

   
?>