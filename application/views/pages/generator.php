<div class="row">
    <div class="col-md-1"></div>				
<div class="col-md-10">
     <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        
    <?php foreach ($pages as $page_item): ?>
                 <li role="presentation" class="<?php if ($page_item === reset($pages)){echo 'active';} ?>"><a href="#<?php echo $page_item['slug']; ?>" aria-controls="<?php echo $page_item['slug']; ?>" role="tab" data-toggle="tab"><?php echo $page_item['title']; ?></a></li>
    <?php endforeach; ?>   
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
     <?php foreach ($pages as $page_item): ?>
                 <div role="tabpanel" class="tab-pane <?php if ($page_item === reset($pages)){echo 'active';} ?>" id="<?php echo $page_item['slug']; ?>"><?php echo $page_item['content']; ?></div>
    <?php endforeach; ?>    
  </div>

</div>
  <div class="col-md-1"></div>	          
</div>