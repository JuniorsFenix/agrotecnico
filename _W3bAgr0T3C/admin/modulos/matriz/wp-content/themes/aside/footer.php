            <div id="hot-close-sidebar-touch"></div>
      </div><!--End #wrap-->	

	  <?php 

        $float_bar_no = ux_get_option('theme_option_enable_floating_bar_disable');

        if (!$float_bar_no) { get_template_part('template/float', 'bar'); }

        ?>

	  <?php wp_footer(); ?>
      <?php /*
      For demo
      */
      //echo '<div class="yunlv" style="z-index:9; display:none; position: fixed; left:0; top:0; width:100%; height:100%; background:url('.get_template_directory_uri().'/img/yunlv.png);"></div>';
      
      //include TEMPLATEPATH.'/demo/styledefinitions.php'; 
      /*
      End demo
      */ 
      ?>

  </body>
</html>