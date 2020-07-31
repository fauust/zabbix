<?php
/*
** Zabbix
** Copyright (C) 2001-2020 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


/**
 * @var CView $this
 */
?>

<script type="text/javascript">
	jQuery(function($) {
		var $form = $('form#housekeeping');

		$form.on('submit', function() {
			$form.trimValues(['#hk_events_trigger', '#hk_events_internal', '#hk_events_discovery', '#hk_events_autoreg',
				'#hk_services', '#hk_audit', '#hk_sessions', '#hk_history', '#hk_trends'
			]);
		});

		jQuery('#hk_events_mode').change(function() {
			jQuery('#hk_events_trigger').prop('disabled', !this.checked);
			jQuery('#hk_events_internal').prop('disabled', !this.checked);
			jQuery('#hk_events_discovery').prop('disabled', !this.checked);
			jQuery('#hk_events_autoreg').prop('disabled', !this.checked);
		});

		jQuery('#hk_services_mode').change(function() {
			jQuery('#hk_services').prop('disabled', !this.checked);
		});

		jQuery('#hk_audit_mode').change(function() {
			jQuery('#hk_audit').prop('disabled', !this.checked);
		});

		jQuery('#hk_sessions_mode').change(function() {
			jQuery('#hk_sessions').prop('disabled', !this.checked);
		});

		jQuery('#hk_history_global').change(function() {
			jQuery('#hk_history').prop('disabled', !this.checked);
		});

		jQuery('#hk_trends_global').change(function() {
			jQuery('#hk_trends').prop('disabled', !this.checked);
		});

		jQuery('#compression_status').change(function() {
			jQuery('#compress_older').prop('disabled', !this.checked);
		});

		jQuery("#resetDefaults").click(function() {
			overlayDialogue({
				'title': <?= json_encode(_('Reset confirmation')) ?>,
				'content': jQuery('<span>').text(<?= json_encode(_('Reset all fields to default values?')) ?>),
				'buttons': [
					{
						'title': <?= json_encode(_('Cancel')) ?>,
						'cancel': true,
						'class': '<?= ZBX_STYLE_BTN_ALT ?>',
						'action': function() {}
					},
					{
						'title': <?= json_encode(_('Reset defaults')) ?>,
						'focused': true,
						'action': function() {
							$('main').prev('.msg-bad').remove();

							// events and alerts
							jQuery('#hk_events_mode')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_events_mode') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_events_trigger')
								.val("<?= DB::getDefault('config', 'hk_events_trigger') ?>");
							jQuery('#hk_events_internal')
								.val("<?= DB::getDefault('config', 'hk_events_internal') ?>");
							jQuery('#hk_events_discovery')
								.val("<?= DB::getDefault('config', 'hk_events_discovery') ?>");
							jQuery('#hk_events_autoreg')
								.val("<?= DB::getDefault('config', 'hk_events_autoreg') ?>");

							// Services
							jQuery('#hk_services_mode')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_services_mode') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_services').val("<?= DB::getDefault('config', 'hk_services') ?>");

							// audit
							jQuery('#hk_audit_mode')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_audit_mode') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_audit').val("<?= DB::getDefault('config', 'hk_audit') ?>");

							// user sessions
							jQuery('#hk_sessions_mode')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_sessions_mode') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_sessions').val("<?= DB::getDefault('config', 'hk_sessions') ?>");

							// history
							jQuery('#hk_history_mode').prop('checked',
								<?= (DB::getDefault('config', 'hk_history_mode') == 1) ? 'true' : 'false' ?>
							);
							jQuery('#hk_history_global')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_history_global') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_history').val("<?= DB::getDefault('config', 'hk_history') ?>");

							// trends
							jQuery('#hk_trends_mode').prop('checked',
								<?= (DB::getDefault('config', 'hk_trends_mode') == 1) ? 'true' : 'false' ?>
							);
							jQuery('#hk_trends_global')
								.prop('checked',
									<?= (DB::getDefault('config', 'hk_trends_global') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#hk_trends').val("<?= DB::getDefault('config', 'hk_trends') ?>");

							// history and trends compression
							jQuery('#compression_status')
								.prop('checked',
									<?= (DB::getDefault('config', 'compression_status') == 1) ? 'true' : 'false' ?>
								)
								.change();
							jQuery('#compress_older').val("<?= DB::getDefault('config', 'compress_older') ?>");
						}
					}
				]
			}, this);
		});
	});
</script>
