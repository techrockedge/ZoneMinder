<?php
//
// ZoneMinder web monitor preset view file, $Date$, $Revision$
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

if ( !canEdit( 'Monitors' ) )
{
    $view = "error";
    return;
}
$sql = "select Id,Name from MonitorPresets";
$presets = array();
$presets[0] = translate('ChoosePreset');
foreach( dbFetchAll( $sql ) as $preset )
{
    $presets[$preset['Id']] = htmlentities( $preset['Name'] );
}

$focusWindow = true;

xhtmlHeaders(__FILE__, translate('MonitorPreset') );
?>
<body>
  <div id="page">
    <div id="header">
      <h2><?php echo translate('MonitorPreset') ?></h2>
    </div>
    <div id="content">
      <form name="contentForm" id="contentForm" method="post" action="?">
        <input type="hidden" name="view" value="none"/>
        <input type="hidden" name="mid" value="<?php echo validNum($_REQUEST['mid']) ?>"/>
        <p>
          <?php echo translate('MonitorPresetIntro') ?>
        </p>
        <p>
          <label for="preset"><?php echo translate('Preset') ?></label><?php echo buildSelect( "preset", $presets, 'configureButtons( this )' ); ?>
        </p>
        <div id="contentButtons">
          <input type="submit" name="saveBtn" value="<?php echo translate('Save') ?>" data-on-click-this="submitPreset" disabled="disabled"/>
          <input type="button" value="<?php echo translate('Cancel') ?>" data-on-click="closeWindow"/>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
