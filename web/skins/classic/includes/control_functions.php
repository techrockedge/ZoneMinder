<?php
//
// ZoneMinder web control function library, $Date$, $Revision$
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


function controlFocus($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="arrowControl focusControls">
  <div class="arrowLabel"><?php echo translate('Near') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['FocusNear'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $control->CanFocusCon() ) { ?> onclick="controlCmd('<?php echo $cmds['FocusStop'] ?>')"<?php } ?>><?php echo translate('Focus') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['FocusFar'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Far') ?></div>
<?php
  if ( $control->CanAutoFocus() ) {
?>
  <button type="button" class="ptzTextBtn" value="<?php echo $cmds['FocusAuto'] ?>" onclick="controlCmd('<?php echo $cmds['FocusAuto'] ?>')"><?php echo translate('Auto') ?></button>
  <button type="button" class="ptzTextBtn" value="<?php echo $cmds['FocusMan'] ?>" onclick="controlCmd('<?php echo $cmds['FocusMan'] ?>')"><?php echo translate('Man') ?></button>
<?php
  }
?>
</div>
<?php
  return ob_get_clean();
}

function controlZoom($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="arrowControl zoomControls">
  <div class="arrowLabel"><?php echo translate('Tele') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['ZoomTele'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $control->CanZoomCon() ) { ?> onclick="controlCmd('<?php echo $cmds['ZoomStop'] ?>')"<?php } ?>><?php echo translate('Zoom') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['ZoomWide'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Wide') ?></div>
<?php
  if ( $control->CanAutoZoom() ) {
?>
  <button type="button" class="ptzTextBtn" value="Auto" onclick="controlCmd('<?php echo $cmds['ZoomAuto'] ?>')"><?php echo translate('Auto') ?></button>
  <button type="button" class="ptzTextBtn" value="Man" onclick="controlCmd('<?php echo $cmds['ZoomMan'] ?>')"><?php echo translate('Man') ?></button>
<?php
  }
?>
</div><?php
  return ob_get_clean();
}

function controlIris($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="arrowControl irisControls">
  <div class="arrowLabel"><?php echo translate('Open') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['IrisOpen'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $control->CanIrisCon() ) { ?> onclick="controlCmd('<?php echo $cmds['IrisStop'] ?>')"<?php } ?>><?php echo translate('Iris') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['IrisClose'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Close') ?></div>
<?php
  if ( $control->CanAutoIris() ) {
?>
  <button type="button" class="ptzTextBtn" value="Auto" onclick="controlCmd('<?php echo $cmds['IrisAuto'] ?>')"><?php echo translate('Auto') ?></button>
  <button type="button" class="ptzTextBtn" value="Man" onclick="controlCmd('<?php echo $cmds['IrisMan'] ?>')"><?php echo translate('Man') ?></button>
<?php
  }
?>
</div>
<?php
  return ob_get_clean();
}

function controlWhite($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="arrowControl whiteControls">
  <div class="arrowLabel"><?php echo translate('In') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['WhiteIn'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $control->CanWhiteCon() ) { ?> onclick="controlCmd('<?php echo $cmds['WhiteStop'] ?>')"<?php } ?>><?php echo translate('White') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['WhiteOut'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Out') ?></div>
<?php
  if ( $control->CanAutoWhite() ) {
?>
  <button type="button" class="ptzTextBtn" value="Auto" onclick="controlCmd('<?php echo $cmds['WhiteAuto'] ?>')"><?php echo translate('Auto') ?></button>
  <button type="button" class="ptzTextBtn" value="Man" onclick="controlCmd('<?php echo $cmds['WhiteMan'] ?>')"><?php echo translate('Man') ?></button>
<?php
  }
?>
</div>
<?php
  return ob_get_clean();
}

function controlPanTilt($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="pantiltControls">
  <div class="pantiltLabel"><?php echo translate('PanTilt') ?></div>
  <div class="pantiltButtons">
<?php
  $hasPan = $control->CanPan();
  $hasTilt = $control->CanTilt();
  $hasDiag = $hasPan && $hasTilt && $control->CanMoveDiag();
?>
    <button type="button" class="arrowBtn upLeftBtn<?php echo $hasDiag?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveUpLeft'] ?>',event,-1,-1)"></button>
    <button type="button" class="arrowBtn upBtn<?php echo $hasTilt?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveUp'] ?>',event,0,-1)"></button>
    <button type="button" class="arrowBtn upRightBtn<?php echo $hasDiag?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveUpRight'] ?>',event,1,-1)"></button>
    <button type="button" class="arrowBtn leftBtn<?php echo $hasPan?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveLeft'] ?>',event,1,0)"></button>
<?php if ( isset($cmds['Center']) ) { ?>
    <button type="button" class="arrowBtn centerBtn" onclick="controlCmd('<?php echo $cmds['Center'] ?>')"></button>
<?php } else { ?>
    <button type="button" class="arrowBtn NocenterBtn"></button>
<?php } ?>
    <button type="button" class="arrowBtn rightBtn<?php echo $hasPan?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveRight'] ?>',event,1,0)"></button>
    <button type="button" class="arrowBtn downLeftBtn<?php echo $hasDiag?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveDownLeft'] ?>',event,-1,1)"></button>
    <button type="button" class="arrowBtn downBtn<?php echo $hasTilt?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveDown'] ?>',event,0,1)"></button>
    <button type="button" class="arrowBtn downRightBtn<?php echo $hasDiag?'':' invisible' ?>" onclick="controlCmd('<?php echo $cmds['MoveDownRight'] ?>',event,1,1)"></button>
  </div>
</div>
<?php
  return ob_get_clean();
}

function controlPresets($monitor, $cmds) {
  $control = $monitor->Control();
  // MAX_PRESETS IS PER LINE
  define('MAX_PRESETS', '12');

  $sql = 'SELECT * FROM ControlPresets WHERE MonitorId = ?';
  $labels = array();
  foreach( dbFetchAll( $sql, NULL, array( $monitor->Id() ) ) as $row ) {
    $labels[$row['Preset']] = $row['Label'];
  }

  $presetBreak = (int)(($control->NumPresets()+1)/((int)(($control->NumPresets()-1)/MAX_PRESETS)+1));

  ob_start();
?>
<div class="presetControls">
  <!--<div><?php echo translate('Presets') ?></div>-->
  <div>
<?php
  for ( $i = 1; $i <= $control->NumPresets(); $i++ ) {
    ?>
      <button type="button" class="ptzNumBtn" title="<?php echo isset($labels[$i])?htmlentities($labels[$i]):'' ?>" value="<?php echo $i ?>" onclick="controlCmd('<?php echo $cmds['PresetGoto'] ?><?php echo $i ?>');"/><?php echo $i ?></button>
<?php
  } // end foreach preset
?>
  </div>
  <div>
<?php
  if ( $control->HasHomePreset() ) {
?>
    <button type="button" class="ptzTextBtn" value="Home" onclick="controlCmd('<?php echo $cmds['PresetHome'] ?>');"><?php echo translate('Home') ?></button>
<?php
  }
  if ( canEdit('Monitors') && $control->CanSetPresets() ) {
?>
    <button type="button" class="ptzTextBtn popup-link" value="Set" data-url="?view=controlpreset&amp;mid=<?php echo $monitor->Id() ?>" data-window-name="zmPreset" data-window-tag="preset"><?php echo translate('Set') ?></button>
<?php
  }
?>
  </div>
</div>
<?php
  return ob_get_clean();
}

function controlPower($monitor, $cmds) {
  $control = $monitor->Control();
  ob_start();
?>
<div class="powerControls">
  <div class="powerLabel"><?php echo translate('Control') ?></div>
  <div>
<?php
  if ( $control->CanWake() ) {
?>
    <button type="button" class="ptzTextBtn" value="Wake" onclick="controlCmd('<?php echo $cmds['Wake'] ?>')"><?php echo translate('Wake') ?></button>
<?php
  }
  if ( $control->CanSleep() ) {
?>
    <button type="button" class="ptzTextBtn" value="Sleep" onclick="controlCmd('<?php echo $cmds['Sleep'] ?>')"><?php echo translate('Sleep') ?></button>
<?php
  }
  if ( $control->CanReset() ) {
?>
    <button type="button" class="ptzTextBtn" value="Reset" onclick="controlCmd('<?php echo $cmds['Reset'] ?>')"><?php echo translate('Reset') ?></button>
<?php
  }
  if ( $control->CanReboot() ) {
?>
    <button type="button" class="ptzTextBtn" value="Reboot" onclick="controlCmd('<?php echo $cmds['Reboot'] ?>')"><?php echo translate('Reboot') ?></button>
<?php
  }
?>
  </div>
</div>
<?php
  return ob_get_clean();
}

function ptzControls($monitor) {
  $control = $monitor->Control();
  //ZM\Error("Control: " . print_r($control,true));
  $cmds = $control->commands();
  //ZM\Error("Cmds: " . print_r($cmds, true));
  ob_start();
?>
<div class="controlsPanel">
<?php
  if ( $control->CanFocus() )
    echo controlFocus($monitor, $cmds);
  if ( $control->CanZoom() )
    echo controlZoom($monitor, $cmds);
  if ( $control->CanIris() )
    echo controlIris($monitor, $cmds);
  if ( $control->CanWhite() )
    echo controlWhite($monitor, $cmds);
  if ( $control->CanMove() ) {
?>
  <div class="pantiltPanel">
<?php echo controlPanTilt($monitor, $cmds); ?>
  </div>
<?php
  }
  if ( $control->CanWake() || $control->CanSleep() || $control->CanReset() )
    echo controlPower($monitor, $cmds);
  if ( $control->HasPresets() )
    echo controlPresets($monitor, $cmds);
?>
</div>
<?php
  return ob_get_clean();
}
?>
