<?php
//
// ZoneMinder web function view file, $Date$, $Revision$
// Copyright (C) 2001-2008 Philip Coombes
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
//

if ( !canEdit('Monitors') ) {
  $view = 'error';
  return;
}

$monitor = ZM\Monitor::find_one(array('Id'=>$_REQUEST['mid']));

$focusWindow = true;

xhtmlHeaders(__FILE__, translate('Function').' - '.validHtmlStr($monitor->Name()));
?>
<body>
  <div id="page">
    <div id="header">
      <h2><?php echo translate('Function').' - '.validHtmlStr($monitor->Name()) ?></h2>
    </div>
    <div id="content">
      <form name="contentForm" id="contentForm" method="post" action="?">
        <input type="hidden" name="view" value="function"/>
        <input type="hidden" name="action" value="function"/>
        <input type="hidden" name="mid" value="<?php echo $monitor->Id() ?>"/>
        <p>
          <select name="newFunction">
<?php
foreach ( getEnumValues('Monitors', 'Function') as $optFunction ) {
?>
            <option value="<?php echo $optFunction ?>"<?php if ( $optFunction == $monitor->Function() ) { ?> selected="selected"<?php } ?>><?php echo translate('Fn'.$optFunction) ?></option>
<?php
}
?>
          </select>
          <label for="newEnabled"><?php echo translate('Enabled') ?></label>
          <input type="checkbox" name="newEnabled" id="newEnabled" value="1"<?php echo $monitor->Enabled() ?' checked="checked"' : '' ?>/>
        </p>
        <div id="contentButtons">
          <button type="submit" value="Save"><?php echo translate('Save') ?></button>
          <button type="button" data-on-click="closeWindow"><?php echo translate('Cancel') ?></button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
