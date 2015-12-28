

<?php
   header("Content-Type: json", true);
   
   error_log($_GET['excludedTags']);
   $excludedTags = $_GET['excludedTags'];
   $excludedTags = json_decode($excludedTags);
   

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

   $searchString = "SELECT DISTINCT tag FROM images";
   if (count($excludedTags))
      $searchString.=' WHERE ';
   foreach ($excludedTags as $tag) {
      $searchString.="tag <> '$tag' AND ";   
   }
   $searchString = chop($searchString, ' AND ');
   
   error_log($searchString);
   $tags = $db->query($searchString);
   
   $html = '';
   
   while($tag=$tags->fetchArray()) {
      error_log('loop');
      $html.= "<a href='#/' id='tagButton$tag[0]' style='margin-left:10px; margin-left:10px;' onClick='toggleTagButton(\"$tag[0]\", this);' class='button round tiny secondary'>$tag[0]</a>";
   }
   
   $arr = array('html' => $html);
   echo json_encode($arr);
   
?>