

<?php

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

   $tags = $db->query("SELECT DISTINCT tag FROM images");
   
  echo "<div class='small-10 small-centered columns'>";
   
   while($tag=$tags->fetchArray()) {
      error_log('loop');
      echo "<a href='#/' id='tagButton$tag[0]' style='margin-left:10px; margin-left:10px;' onClick='toggleTagButton(\"$tag[0]\", this);' class='button round secondary'>$tag[0]</a>";
   }  

   echo "</div>";
   
?>