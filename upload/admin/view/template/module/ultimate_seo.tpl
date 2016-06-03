<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button onclick="$('#form').submit();" type="submit" form="form-user-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <div>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    </div>
     <div class="panel panel-default">
		  <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
  <div class="panel-body">
 <div class="table-responsive">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="table">
				<tr>
					<td  class="left"><?php echo $entry_meta_num; ?><br /><span class = "help"><?php echo $entry_meta_num_description; ?></span></td>
					<td  class="left">
					<input type="text" name="useo_meta_num" value="<?php echo $useo_meta_num; ?>" />
					</td>
				</tr>
				<tr>
					<td  class="left"><?php echo $entry_auto_meta; ?><br /><span class = "help"><?php echo $entry_auto_meta_description; ?></span></td>
					<td  class="left">
					<input type="checkbox" name="useo_auto_meta" value = "yes" <?php echo $useo_auto_meta; ?>  />
					</td>
				</tr>
			</table>
			</form>
		</div> <!-- end of .content -->
		
	</div><!-- end of .panel-body -->

</div> <!-- end of .container -->
</div> <!-- end of #content -->

