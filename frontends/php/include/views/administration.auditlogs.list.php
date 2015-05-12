<?php
/*
** Zabbix
** Copyright (C) 2001-2015 Zabbix SIA
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

$auditWidget = (new CWidget())->setTitle(_('Audit log'));

// header
// create filter
$filterForm = new CFilter('web.auditlogs.filter.state');

$filterColumn = new CFormList();
$filterColumn->addRow(_('User'), array(
	new CTextBox('alias', $this->data['alias'], 20),
	new CButton('btn1', _('Select'),
		'return PopUp("popup.php?dstfrm=zbx_filter&dstfld1=alias&srctbl=users&srcfld1=alias&real_hosts=1");'
	)
));
$filterColumn->addRow(_('Action'), new CComboBox('action', $this->data['action'], null, array(
	-1 => _('All'),
	AUDIT_ACTION_LOGIN => _('Login'),
	AUDIT_ACTION_LOGOUT => _('Logout'),
	AUDIT_ACTION_ADD => _('Add'),
	AUDIT_ACTION_UPDATE => _('Update'),
	AUDIT_ACTION_DELETE => _('Delete'),
	AUDIT_ACTION_ENABLE => _('Enable'),
	AUDIT_ACTION_DISABLE => _('Disable')
)));
$filterColumn->addRow(_('Resource'), new CComboBox('resourcetype', $this->data['resourcetype'], null,
	array(-1 => _('All')) + audit_resource2str()
));

$filterForm->addColumn($filterColumn);
$filterForm->addNavigator();
$auditWidget->addItem($filterForm);

// create form
$auditForm = new CForm('get');
$auditForm->setName('auditForm');

// create table
$auditTable = new CTableInfo();
$auditTable->setHeader(array(
	_('Time'),
	_('User'),
	_('IP'),
	_('Resource'),
	_('Action'),
	_('ID'),
	_('Description'),
	_('Details')
));
foreach ($this->data['actions'] as $action) {
	$details = array();
	if (is_array($action['details'])) {
		foreach ($action['details'] as $detail) {
			$details[] = array($detail['table_name'].'.'.$detail['field_name'].NAME_DELIMITER.$detail['oldvalue'].' => '.$detail['newvalue'], BR());
		}
	}
	else {
		$details = $action['details'];
	}

	$auditTable->addRow(array(
		zbx_date2str(DATE_TIME_FORMAT_SECONDS, $action['clock']),
		$action['alias'],
		$action['ip'],
		$action['resourcetype'],
		$action['action'],
		$action['resourceid'],
		$action['resourcename'],
		new CCol($details, 'wraptext')
	));
}

// append table to form
$auditForm->addItem(array($auditTable, $this->data['paging']));

// append navigation bar js
$objData = array(
	'id' => 'timeline_1',
	'domid' => 'events',
	'loadSBox' => 0,
	'loadImage' => 0,
	'loadScroll' => 1,
	'dynamic' => 0,
	'mainObject' => 1,
	'periodFixed' => CProfile::get('web.auditlogs.timelinefixed', 1),
	'sliderMaximumTimePeriod' => ZBX_MAX_PERIOD
);
zbx_add_post_js('timeControl.addObject("events", '.zbx_jsvalue($this->data['timeline']).', '.zbx_jsvalue($objData).');');
zbx_add_post_js('timeControl.processObjects();');

// append form to widget
$auditWidget->addItem($auditForm);

return $auditWidget;
