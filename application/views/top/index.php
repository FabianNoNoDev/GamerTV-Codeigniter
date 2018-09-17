
<div class="col-xs-12 col-sm-12">
        <div class="row">
            
            <center><h2>GamerTV Top100 Broadcaster</h2></center>
            
                       <div class="table-responsive">
        <table id="top100" summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-striped table-bordered">
          <caption class="text-center"><?php echo ucfirst($site_lang['total_database']); ?>: <?php echo number_format($community['name']); ?> <?php echo $site_lang['channel']; ?>, <?php echo number_format($community['views']); ?> <?php echo $site_lang['views']; ?>,  <?php echo number_format($community['followers']); ?> <?php echo $site_lang['followers']; ?></caption>
          <thead>
            <tr>
              <th><?php echo ucfirst($site_lang['channel_name']); ?></th>
              <th><?php echo ucfirst($site_lang['channel_link']); ?></th>
              <th><?php echo ucfirst($site_lang['followers']); ?></th>
              <th><?php echo ucfirst($site_lang['views']); ?></th>
              <th><?php echo ucfirst($site_lang['status']); ?></th>
            </tr>
          </thead>
          <tbody>
                <?php foreach ($top_list as $top_item): ?>
                   <tr>
                     <td><a href="/top/<?php echo "".$top_item['name'].""; ?>"><?php echo ucfirst($top_item['display_name']); ?></a></td>
                     <td><a target="_blank" href="//twitch.tv/<?php echo "//".$top_item['name'].""; ?>">Twitch.tv</a></td>
                     <td><?php echo number_format($top_item['followers']); ?></td>
                     <td><?php echo number_format($top_item['views']); ?></td>
                     <td>
                     <?php if($top_item['online']==1)   
                     {
                       echo "<font color='green'><b>Online</b></font>";  
                     }
                     else
                     {
                      echo "<font color='crimson'>Offline</font>";   
                     }   
                     ?>
                     </td>
                   </tr>
               <?php endforeach; ?>   
            
                </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-center"><?php echo ucfirst($site_lang['every_data_from_twitch']); ?></td>
            </tr>
          </tfoot>
        </table>
      </div><!--end of .table-responsive--> 
            

        </div>
</div>