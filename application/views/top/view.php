<div class="row">
				
<div class="col-md-12">
				
<div class="panel panel-default">

    <div class="panel-heading"><?php echo ucfirst($channeldata->name); ?></div>
	
    <div class="panel-body">
			
			<div style="padding:0" class="panel panel-default col-md-4">
			
                            <div class="panel-heading"><i class="fa fa-twitch"></i> <?php echo ucfirst($site_lang['channel_information']); ?></div>
				
				<table class="table table-striped table-bordered table-responsive">
				
					<tbody>
					<tr>
                                            <td  width="35%">Twitch partner</td>
                                            <td>
                                               <?php if($channeldata->partner == TRUE)
                                               { 
                                                 echo ucfirst($site_lang['yes']);
                                               }
                                               else
                                               {
                                                echo ucfirst($site_lang['no']); 
                                               }    
                                                   ?>
                                            </td>     
                                            </td>
					</tr>
                                        <tr>
                                            <td><?php echo ucfirst($site_lang['views']); ?></td>
                                            <td><?php echo number_format($channeldata->views); ?></td>
					</tr>                 
                                         <tr>
                                            <td><?php echo ucfirst($site_lang['followers']); ?></td>
                                            <td><?php echo number_format($channeldata->followers); ?></td>
					</tr>
                                        <tr>
                                            <td><?php echo ucfirst($site_lang['channel_started']); ?></td>
                                            <td><?php echo preg_replace("/[^0-9,:s\-.]/"," ",$channeldata->created_at); ?></td>
					</tr>  
					<tr>
                                            <td><?php echo ucfirst($site_lang['language']); ?></td>
                                            <td><?php echo ucfirst($channeldata->language); ?></td>
					</tr>
                                        <tr>
                                            <td><?php echo ucfirst($site_lang['last_played']); ?></td>
                                            <td><?php echo $channeldata->game; ?></td>
					</tr>
                                                        
                                        <tr>
                                                <td>Twitch</td>
                                                <td><a role="button" class="btn btn-twitch btn-xs" href="<?php echo $channeldata->url; ?>"><i class="fa fa-twitch"></i> Subscribe!</a></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo ucfirst($site_lang['saved_videos']); ?></td>
                                            <td><?php echo number_format($channelvideos->_total); ?></td>
					</tr>
							
						
					</tbody>
					
				</table>

				

			</div>
		
			<div style="margin-left: 10px; width: 65%; padding:0" class="panel panel-default col-md-8">
				<img alt="banner" src="<?php echo $channeldata->video_banner; ?>" class="img-responsive" style="margin: 0 auto; padding-bottom: 10px;">

			</div>


    </div>

</div>

					
				</div>
			
			</div>