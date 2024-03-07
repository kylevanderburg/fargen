<?php
/*
NoteForge Hammer
	by Kyle Vanderburg, in Poplar Bluff and Springfield, Missouri, and Norman, OK.
Debuted on November 30, 2007, at www.kyledavey.com/blink.  Went live December 2, 2007.
All code copyright Kyle Vanderburg

This code is a module that requires the Hammer Core in order to fully work.
*/
$hr = new vio_far_activity($hammer);
$hr->restrict();

// include "far-standards.php";

// $class = new vio_class($hammer);
// $class->restrict();
// $hammer->debug();
echo "<div class=\"hh\"><h1>Hammer &raquo; Projects</h1></div>";
$hr->toolbar();
switch ($hammer->location[1]){
	case "new":
	case "insert":
	case "modify":
	case "write":
		//Insert new stuff
		if($hammer->location['action']==="insert"){$hr->create();}

		if(($hammer->location['action']==="insert") xor ($hammer->location['action']==="write")){
			if(!isset($hr->id)){$hr->id=$_POST['id'];}
			if(is_array($_POST['category'])){$_POST['category'] = implode(",",$_POST['category']);}
			unset($_POST['options']);
			$hr->update($_POST);
		}
		
		if($hammer->location['action']=="modify"){$hr->id=$hammer->location['item'];}

		if($hammer->location['action']=="insert"||$hammer->location['action']=="modify"||$hammer->location['action']=="write"){$hr->get();}
		
		if(($hammer->location['action']=="insert" OR $hammer->location['action']=="write") AND isset($_POST['saveclose'])){?>
		<script>location.href = "<?php echo "/".$hr->page."/";?>"</script>
		<?php } 
		$hr->saveCloseHandler($_POST);
		$hr->savedAlert($action);
		// var_dump($hr->row);
		?>
		
		<form name="<?php echo $hr->page; ?>" action="/<?php echo $hr->page;?>/<?php if($hammer->location['action']=="new"){echo "insert";}elseif(($hammer->location['action']=="modify")||($hammer->location['action']=="insert")||($hammer->location['action']=="write")){echo "write";} ?>/" method="post" enctype="multipart/form-data" autocomplete="off">
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<?php $hammer->writeTab("Details",1); ?>
				<?php /*if($hammer->location['action']!="new"){?><?php $hammer->writeTab("Comments"); ?><?php }*/ ?>
				<?php if($hammer->location['action']!="new"){?><?php $hammer->writeTab("Audit"); ?><?php } ?>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<?php $hammer->writeTabHeader("details",1); ?>
				<br />
					<table class="table table-hover">
						<tr><td><?php $hr->datepicker("date","Date");?></td></tr>
						<tr><td><?php $hr->textinput("name","Name");?></td></tr>
						<tr><td>
							<div class="form-group form-group-lg">
								<label for="<?php echo $hr->page;?>-category">Category</label>
								<input type="hidden" name="category" value="" />
								<select id="<?php echo $hr->page;?>-category" name="category[]" class="form-control lz-field" multiple>
								<?php 
									$cats = explode(',',$hr->row['category']);
									foreach($hr->categories as $c)
									{
										echo "<optgroup label=\"".$c['name']."\">";
										foreach($hr->items as $i){
											switch ($i['category']){
												case $c['name']:
													echo "<option value='" . $i['code'] . "'";if (in_array($i['code'], $cats) !== FALSE){echo " selected";} echo ">".$c['name']." - ".$i['name'] . "</option>";
												break;
											}
										}
									
									}
								?>
								</select>
							</div>
						</tr></td>
						<tr><td>
						<div class="form-group form-group-lg">
							<label for="<?php echo $hr->page;?>-scope">Scope</label>
							<br />
							<?php
							$aopt['0']="N/A";
							$aopt['1']="Local";
							$aopt['2']="Regional";
							$aopt['3']="National";
							$aopt['4']="International";
							$hr->radio("scope",$aopt,$hr->row['scope']);
							?>
							</div>
						</td></tr>
						<tr><td>
						<div class="form-group form-group-lg">
							<label for="<?php echo $hr->page;?>-invited">Invited/Juried</label>
							<br />
							<?php
							unset($aopt);
							$aopt['0']="N/A";
							$aopt['1']="Invited";
							$aopt['2']="Juried";
							$hr->radio("invited",$aopt,$hr->row['invited']);
							?>
							</div>
						</td></tr>
						<tr><td><?php $hr->textarea("comments","Additional Information");?></td></tr>
					</table>
				<?php $hammer->writeTabFooter(); ?>
				<?php /*$hammer->writeTabHeader("comments"); ?><br /><?php include "comments.php"; ?><?php $hammer->writeTabFooter(); */?>
				<?php $hammer->writeTabHeader("audit"); ?><br /><?php include "audit.php"; ?><?php $hammer->writeTabFooter(); ?>
			</div>
		</div>
		<br />
		<input type="hidden" name="id" value="<?php echo $hr->id; ?>">
		<div class="text-center">
		<div class="btn-group btn-group-lg">
			<?php echo $hr->saveButton(); 
			echo $hr->saveCloseButton();
			echo $hr->deleteButton($hr->row['id'],$hr->row['name']); ?>
		</div>
		</div>
		</form>
		<script><?php $hr->deleteHandler();?></script>
		<?php
	break;
	
	case "export":
		$hr->export("vio-far-activity");
	break;
	
	default:
		$hr->getPageJS();
		?>

		<br />
		<?php
		$thefuture = new DateTime('now');
		$thefuture = $thefuture->add(new DateInterval('P30D'));
		$hr->qcount();
				
		echo "<div role=\"tabpanel\">
			<ul class=\"nav nav-tabs\" role=\"tablist\">";
		$hammer->writeTab("All",1);
		$hammer->writeTab("Archived");
		echo "</ul>";
		echo "<div class=\"tab-content\">";
		$hammer->writeTabHeader("All",1);
		$hr->listIndexWrapper("`archived`='0'","",1,"50","",$hammer->getHD());
		$hammer->writeTabFooter();

		$hammer->writeTabHeader("Archived");
		$hr->listIndexWrapper("`archived`>0","",1,"50","",$hammer->getHD());
		$hammer->writeTabFooter();

		echo "</div>";
		echo "</div>";
		 
} ?>
