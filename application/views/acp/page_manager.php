   <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Page Manager <small>Add/Edit Custom Pages</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">
                        
                        <?php echo validation_errors(); ?>
                        <?php echo $debug; ?>
                        
                        <?php echo form_open("acp/page_manager");?>

                            <div class="form-group">
                                <label>Parent Page</label>
                                <?php echo form_dropdown('parent', $parent_pages_array, $default_parent,'class="form-control"');?>
                            </div>
                            
                            <div class="form-group">
                                <label>Title</label>
                                <?php echo form_input($page_title);?>
                            </div>
                        
                            <div class="form-group">
                                <label>Slug</label>
                                <?php echo form_input($slug);?>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <?php echo form_textarea($content);?>
                            </div>

                            <?php echo form_submit($submit);?>

                        <?php echo form_close();?>

                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default col-lg-8" style="padding:0">
			
                            <div class="panel-heading">Available Pages</div>
				
				<table class="table table-striped table-bordered table-responsive">
				<tbody id="pages_table">

				</tbody>
					
				</table>

				

			</div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <script>
        window.pages=1;
        </script>


        <!-- /#page-wrapper -->