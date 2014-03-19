<div class="gp_top_main_left">
 <h4>今が旬！注目のキーワード</h4>
  <ul>
   <?php
     $res = get_notable_keyword( 5, true );
     foreach( $res as $keyword ){
       print( '<li><a href="?s=' . $keyword . '&product=true">' . $keyword . '</a></li>' );
     }
   ?>
  </ul>
</div>
