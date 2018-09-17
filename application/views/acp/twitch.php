   <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Twitch Channels <small>Add/Remove/Ban Channels</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <?php echo validation_errors(); ?>
                            <?php echo $debug; ?>

                            <?php echo form_open("acp/twitch");?>

                                <div class="form-group">
                                    <label>Channel Name</label>
                                    <?php echo form_input($twitch_title);?>
                                </div>

                                <?php echo form_submit($submit);?>

                                <?php echo form_submit($ban);?>

                            <?php echo form_close();?>
                        </div>
                        <div><h1></h1></div>
                        <div>
                            <?php echo validation_errors(); ?>
                            <?php echo $debug; ?>

                            <?php echo form_open("acp/twitch");?>

                                <div class="form-group">
                                    <label>Twitch Group Name</label>
                                    <?php echo form_input($group_title);?>
                                </div>

                                <?php echo form_submit($group_submit);?>

                            <?php echo form_close();?>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default col-lg-8" style="padding:0">
			
                            <div class="panel-heading">Banned Channels</div>
				
				<table class="table table-striped table-bordered table-responsive">
				<tbody id="twitch_ban_table">

				</tbody>
					
				</table>

				

			</div>
                        <div class="panel panel-default col-lg-8" style="padding:0">
			
                            <div class="panel-heading">Twitch Groups</div>
				
				<table class="table table-striped table-bordered table-responsive">
				<tbody id="twitch_group_table">

				</tbody>
					
				</table>

				

			</div>
                        <div class="panel panel-default col-lg-8" style="padding:0">
			
                            <div class="panel-heading">Custom Twitch Channels</div>
				
				<table class="table table-striped table-bordered table-responsive">
				<tbody id="twitch_custom_table">

				</tbody>
					
				</table>

				

			</div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <script>
        window.twitch=1;
        </script>