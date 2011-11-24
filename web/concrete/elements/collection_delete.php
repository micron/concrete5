<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-ui">
<?
$sh = Loader::helper('concrete/dashboard/sitemap');
$numChildren = $c->getNumChildren();
?>

<script type="text/javascript">
$(function() {
	$("#ccmDeletePageForm").ajaxForm({
		type: 'POST',
		iframe: true,
		beforeSubmit: function() {
			jQuery.fn.dialog.showLoader();
		},
		success: function(r) {
			var r = eval('(' + r + ')');
			if (r != null && r.rel == 'SITEMAP') {
				jQuery.fn.dialog.hideLoader();
				jQuery.fn.dialog.closeTop();
				<? if ($_REQUEST['display_mode'] == 'explore') { ?>
					ccmSitemapExploreNode('<?=$_REQUEST['instance_id']?>', 'explore', '<?=$_REQUEST['select_mode']?>', resp.cParentID);
				<? } else { ?>
					deleteBranchFade(r.cID);
				<? } ?>
	 			ccmAlert.hud(ccmi18n_sitemap.deletePageSuccessMsg, 2000, 'delete_small', ccmi18n_sitemap.deletePage);
			} else {
				window.location.href = '<?=DIR_REL?>/<?=DISPATCHER_FILENAME?>?cID=' + r.cParentID;
			}
		}
	});
});
</script>

<? if ($c->getCollectionID() == 1) {  ?>
	<div class="error alert-message"><?=t('You may not delete the home page.');?></div>
	<div class="dialog-buttons"><input type="button" class="btn" value="<?=t('Close')?>" onclick="jQuery.fn.dialog.closeTop()" /></div>
<? } else {	?>
	<? if ($c->isPendingDelete()) { ?>
		<div class="notice alert-message"><?=t('This page has been marked for deletion.');?></div>
		<?
		
		$u = new User();
		$puID = $u->getUserID();
		
		if ($puID == $c->getPendingActionUserID()) { ?>
			<?=t('You marked this page for deletion on <strong>%s</strong>', date(DATE_APP_PAGE_VERSIONS, strtotime($c->getPendingActionDateTime())))?><br><br>
	
			<form method="get" id="ccmDeletePageForm" action="<?=DIR_REL?>/<?=DISPATCHER_FILENAME?>">
				<div class="dialog-buttons"><input type="button" class="btn ccm-button-left" value="<?=t('Close')?>" onclick="jQuery.fn.dialog.closeTop()" />
					<input type="submit" class="btn ccm-button-right primary" onclick="$('#ccmDeletePageForm').submit()" value="<?=t('Cancel Delete')?>" />
				</div>
				<input type="hidden" name="cID" value="<?=$c->getCollectionID()?>">
				<input type="hidden" name="ctask" value="clear_pending_action">
				<input type="hidden" name="rel" value="<?=$_REQUEST['rel']?>" />
				<input type="hidden" name="display_mode" value="<?=$_REQUEST['display_mode']?>" />
				<input type="hidden" name="instance_id" value="<?=$_REQUEST['instance_id']?>" />
				<input type="hidden" name="select_mode" value="<?=$_REQUEST['select_mode']?>" />
			</form>
		<? } ?>
	<? } else if ($c->isPendingMove() || $c->isPendingCopy()) { ?>
		<div class="error alert-message"><?=t('Since this page is being moved or copied, it cannot be deleted.')?></div>
		<div class="dialog-buttons"><input type="button" class="btn" value="<?=t('Close')?>" onclick="jQuery.fn.dialog.closeTop()" /></div>
		
	<? } else if ($numChildren > 0 && !$cp->canAdminPage()) { ?>
		<div class="error alert-message"><?=t('Before you can delete this page, you must delete all of its child pages.')?></div>
		<div class="dialog-buttons"><input type="button" class="btn" value="<?=t('Close')?>" onclick="jQuery.fn.dialog.closeTop()" /></div>
		
	<? } else { 
		?>
		
		<div class="ccm-buttons">

		<form method="post" id="ccmDeletePageForm" action="<?=$c->getCollectionAction()?>">	
			<input type="hidden" name="rel" value="<?=$_REQUEST['rel']?>" />

			<div class="dialog-buttons"><input type="button" class="btn" value="<?=t('Close')?>" onclick="jQuery.fn.dialog.closeTop()" />
			<a href="javascript:void(0)" onclick="$('#ccmDeletePageForm').submit()" class="ccm-button-right btn error"><span><?=t('Delete Page')?></span></a>
			</div>
		<h3><?=t('Are you sure you wish to delete this page?')?></h3>
		<? if ($cp->canAdminPage() && $numChildren > 0) { ?>
			<h4><?=t('This will remove %s child page(s).', $numChildren)?></h4>
		<? } ?>
		
		<? if (ENABLE_TRASH_CAN) { ?>
			<p><?=t('Deleted pages are moved to the trash can in the sitemap.')?></p>
		<? } else { ?>
			<p><?=t('This cannot be undone.')?></p>
		<? } ?>
		
			<input type="hidden" name="cID" value="<?=$c->getCollectionID()?>">
			<input type="hidden" name="ctask" value="delete">
			<input type="hidden" name="processCollection" value="1" />
			<input type="hidden" name="display_mode" value="<?=$_REQUEST['display_mode']?>" />
			<input type="hidden" name="instance_id" value="<?=$_REQUEST['instance_id']?>" />
			<input type="hidden" name="select_mode" value="<?=$_REQUEST['select_mode']?>" />
		</form>
		</div>
		
	<? }
	
}?>