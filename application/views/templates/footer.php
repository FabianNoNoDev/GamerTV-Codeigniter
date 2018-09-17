      <hr>


      </div> 
      
      <div class="container">   
      
        <div class="col-sm-12 footer">

                    <div class="col-sm-4 col-md-4">
                        <h3><?php echo ucfirst($site_lang['followus']); ?></h3>
                       <iframe allowtransparency="true" style="border:none; overflow:hidden; width:292px; height:215px;" scrolling="no" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fgamertv.hu&amp;width=292&amp;height=290&amp;colorscheme=dark&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=247377361968053" frameborder="0"></iframe>  
                    </div>
                    
                    <div class="col-sm-4 col-md-4">
                        <h3><?php echo ucfirst($site_lang['top_channels']); ?></h3>
                        <p>
                    <?php foreach ($footer_top as $top_item): ?>
                   <h4><i class="fa fa-twitch"></i> <a href="/top/<?php echo "".$top_item['name'].""; ?>"><?php echo ucfirst($top_item['display_name']); ?></a></h4>
                    <?php endforeach; ?>      
                    </p>
                    </div>
            
                    <div class="col-sm-4 col-md-4">
                        <h3><?php echo ucfirst($site_lang['statistics']); ?></h3>
                      <h4>  <?php echo number_format($footer_community['name']); ?> <?php echo $site_lang['channel']; ?> </h4>
                      <h4> <?php echo number_format($footer_community['views']); ?> <?php echo $site_lang['views']; ?>  </h4>
                      <h4>  <?php echo number_format($footer_community['followers']); ?> <?php echo $site_lang['followers']; ?></h4>
                        
                    </div>
             
            
        </div>     
       <div class="col-sm-12 footer footer-nav">
           <p class="pull-left pull-footer-nav">&copy; 2014-2016 <?php echo $page_title; ?> | <?php echo ucfirst($site_lang['generated_in']); ?> <strong>{elapsed_time}</strong> <?php echo $site_lang['second']; ?>!</p>
       </div> 
        


    </div><!--/.container-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script> 
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    
    
    <script src="<?php echo base_url(); ?>assets/js/general.js"></script>
    <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-7502866-47', 'auto');
            ga('send', 'pageview');

    </script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.5&appId=578396905530190";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
  </body>
</html>