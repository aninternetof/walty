

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
   
   $searchString = "SELECT DISTINCT path FROM images";

   $pathsResult = $db->query($searchString);
   
   $paths = array();
   while($path=$pathsResult->fetchArray()) {
      array_push($paths, $path);
   }
  
  $prefix = "../user-images/";
  $html= "<div class='row'>";  

  for($i=0; $i<count($paths); $i++) {
      $p = $paths[$i][0];
      $name = substr($p, strlen($prefix)-1);
      $name = chop($name, '.jpg');
      $divClass = 'small-6 columns';
      if ($i==count($paths)-1)
         $divClass.=' end';
      $html.= "<div class='$divClass'><div class='panel' id='panel_"."$name'><div style='position:relative'><img src=\"$p\" width='600px' style='margin-bottom:10px'>";
      $html.= "<div style='position:absolute; top:0px; right:90%; width:30px; height: 30px;'><a href='#/' onClick='removeImage(\"$p\")'><i class='fi-x' style='font-size:40px; color:rgba(255,128,128,0.6);'></i></a></div></div>";
      $tags = $db->query("SELECT tag FROM images WHERE path = '$p'");
      $html.="<div id='tagArea' style='display:inline'>";
      while($tag=$tags->fetchArray()) {
         $html.= "<a href='#/' onClick='removeTag(\"$p\", \"$tag[0]\")' class='button tiny round secondary tag' style='margin: 2px 2px 2px 0px'>$tag[0]</a>";
      }
      $html.="</div>";
      $html.="<a href='#/' id='displayFieldButton' onClick='openAddTagField(this.parentNode)' class='button tiny round' style='margin: 2px 2px 2px 0px;'><i class='fi-plus'></i></a>";
      $html.="<a href='#/' id='hideFieldButton' onClick='closeAddTagField(this.parentNode)' class='button tiny round alert' style='margin: 2px 2px 2px 0px; display:none'><i class='fi-x'></i></a>";
      $html.="<form style='margin-top:20px' action='javascript:addTag(\"$p\");'>";
      $html.="<div class='row collapse postfix-radius'>";
         $html.="<div class='small-9 columns'>";
            $html.="<input id='field' placeholder='add a new tag' type='text' style='display:none; border-top-left-radius: 20px; border-bottom-left-radius: 20px' name='newTagField'>";
         $html.="</div>";
         $html.="<div class='small-3 columns'>";
            $html.="<a href='#/' id='submitButton' onClick='addTag(\"$p\")' style='display:none' class='button postfix round'><i class='fi-check'></i></a>";
         $html.="</div>";
         $html.="<div id='newTagsArea' style='display:none'></div>";
         $html.="<a href='#/' id='submitFromListButton' onClick='addTags(\"$p\")' style='display:none; margin-left:10px' class='button round tiny'><i class='fi-check'></i></a>";
      $html.="</div>";
      $html.="</form>";
      $html.= "</div></div>";

   }   
   
   $html.= "</div>";

   
   $arr = array('html' => $html);

   echo json_encode($arr);

   
?>