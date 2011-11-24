
<? $ih = Loader::helper('concrete/interface'); ?>
<?
$enabledVals = array('0' => t('No'), '1' => t('Yes'));
$secureVals = array('' => t('None'), 'SSL' => 'SSL', 'TLS' => 'TLS');
$form = Loader::helper('form');
?>
	

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Sitewide Mail Settings'), false, 'span12 offset2', false)?>
	<div class="ccm-pane-body">
	<form method="post" action="<?=$this->url('/dashboard/system/mail/method', 'save_settings')?>" id="mail-settings-form">
	<fieldset>
	<legend><?=t('Send Mail Method')?></legend>
	<div class="clearfix">
	<label></label>
	<div class="input">
	<ul class="inputs-list">
	<li><label><?=$form->radio('MAIL_SEND_METHOD', 'PHP_MAIL', MAIL_SEND_METHOD)?> <span><?=t('Default PHP Mail Function')?></span></label></li>
	<li><label><?=$form->radio('MAIL_SEND_METHOD', 'SMTP', MAIL_SEND_METHOD)?> <span><?=t('External SMTP Server')?></span></label></li>
	</ul>
	</div>
	<div>
	</fieldset>
	<fieldset id="ccm-settings-mail-smtp">
		<legend><?=t('SMTP Settings')?></legend>
			<div class="clearfix">
				<?=$form->label('MAIL_SEND_METHOD_SMTP_SERVER','Mail Server');?>
				<div class="input">
					<?=$form->text('MAIL_SEND_METHOD_SMTP_SERVER', Config::get('MAIL_SEND_METHOD_SMTP_SERVER'))?>
				</div>
			</div>
			<div class="clearfix">
				<?=$form->label('MAIL_SEND_METHOD_SMTP_USERNAME','Username');?>
				<div class="input">
					<?=$form->text('MAIL_SEND_METHOD_SMTP_USERNAME', Config::get('MAIL_SEND_METHOD_SMTP_USERNAME'))?>
				</div>
			</div>
			<div class="clearfix">
				<?=$form->label('MAIL_SEND_METHOD_SMTP_PASSWORD','Password');?>
				<div class="input">
					<?=$form->text('MAIL_SEND_METHOD_SMTP_PASSWORD', Config::get('MAIL_SEND_METHOD_SMTP_PASSWORD'))?>
				</div>
			</div>
			
			<div class="clearfix">
				<?=$form->label('MAIL_SEND_METHOD_SMTP_ENCRYPTION','Encryption');?>
				<div class="input">
					<?=$form->select('MAIL_SEND_METHOD_SMTP_ENCRYPTION', $secureVals, Config::get('MAIL_SEND_METHOD_SMTP_ENCRYPTION'))?>
				</div>
			</div>
			<div class="clearfix">
				<?=$form->label('MAIL_SEND_METHOD_SMTP_PORT','Port (Leave blank for default)');?>
				<div class="input">
					<?=$form->text('MAIL_SEND_METHOD_SMTP_PORT', Config::get('MAIL_SEND_METHOD_SMTP_PORT'))?>
				</div>
			</div>	
	</fieldset>	
	</div>
	<div class="ccm-pane-footer">
		<?=$ih->submit(t('Save'), 'mail-settings-form','right','primary')?>
	</div>
	</form>
	
	</div>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>
	
		<script type="text/javascript">
	ccm_checkMailSettings = function() {
		obj = $("input[name=MAIL_SEND_METHOD]:checked");
		if (obj.val() == 'SMTP') {
			$("#ccm-settings-mail-smtp").show();	
		} else {
			$("#ccm-settings-mail-smtp").hide();	
		}
	}

	$(function() {
		$("input[name=MAIL_SEND_METHOD]").click(function() {
			ccm_checkMailSettings();
		});
		ccm_checkMailSettings();	
	});

	</script>
