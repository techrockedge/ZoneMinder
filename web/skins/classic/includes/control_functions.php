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

function getControlCommands( $monitor ) {
  $cmds = array();

  $cmds['Wake'] = 'wake';
  $cmds['Sleep'] = 'sleep';
  $cmds['Reset'] = 'reset';
  $cmds['Reboot'] = 'reboot';

  $cmds['PresetSet'] = 'presetSet';
  $cmds['PresetGoto'] = 'presetGoto';
  $cmds['PresetHome'] = 'presetHome';

  if ( $monitor->CanZoom() ) {
    if ( $monitor->CanZoomCon() )
      $cmds['ZoomRoot'] = 'zoomCon';
    elseif ( $monitor->CanZoomRel() )
      $cmds['ZoomRoot'] = 'zoomRel';
    elseif ( $monitor->CanZoomAbs() )
      $cmds['ZoomRoot'] = 'zoomAbs';
    $cmds['ZoomTele'] = $cmds['ZoomRoot'].'Tele';
    $cmds['ZoomWide'] = $cmds['ZoomRoot'].'Wide';
    $cmds['ZoomStop'] = 'zoomStop';
    $cmds['ZoomAuto'] = 'zoomAuto';
    $cmds['ZoomMan'] = 'zoomMan';
  }

  if ( $monitor->CanFocus() ) {
    if ( $monitor->CanFocusCon() )
      $cmds['FocusRoot'] = 'focusCon';
    elseif ( $monitor->CanFocusRel() )
      $cmds['FocusRoot'] = 'focusRel';
    elseif ( $monitor->CanFocusAbs() )
      $cmds['FocusRoot'] = 'focusAbs';
    $cmds['FocusFar'] = $cmds['FocusRoot'].'Far';
    $cmds['FocusNear'] = $cmds['FocusRoot'].'Near';
    $cmds['FocusStop'] = 'focusStop';
    $cmds['FocusAuto'] = 'focusAuto';
    $cmds['FocusMan'] = 'focusMan';
  }

  if ( $monitor->CanIris() ) {
    if ( $monitor->CanIrisCon() )
      $cmds['IrisRoot'] = 'irisCon';
    elseif ( $monitor->CanIrisRel() )
      $cmds['IrisRoot'] = 'irisRel';
    elseif ( $monitor->CanIrisAbs() )
      $cmds['IrisRoot'] = 'irisAbs';
    $cmds['IrisOpen'] = $cmds['IrisRoot'].'Open';
    $cmds['IrisClose'] = $cmds['IrisRoot'].'Close';
    $cmds['IrisStop'] = 'irisStop';
    $cmds['IrisAuto'] = 'irisAuto';
    $cmds['IrisMan'] = 'irisMan';
  }

  if ( $monitor->CanWhite() ) {
    if ( $monitor->CanWhiteCon() )
      $cmds['WhiteRoot'] = 'whiteCon';
    elseif ( $monitor->CanWhiteRel() )
      $cmds['WhiteRoot'] = 'whiteRel';
    elseif ( $monitor->CanWhiteAbs() )
      $cmds['WhiteRoot'] = 'whiteAbs';
    $cmds['WhiteIn'] = $cmds['WhiteRoot'].'In';
    $cmds['WhiteOut'] = $cmds['WhiteRoot'].'Out';
    $cmds['WhiteAuto'] = 'whiteAuto';
    $cmds['WhiteMan'] = 'whiteMan';
  }

  if ( $monitor->CanGain() ) {
    if ( $monitor->CanGainCon() )
      $cmds['GainRoot'] = 'gainCon';
    elseif ( $monitor->CanGainRel() )
      $cmds['GainRoot'] = 'gainRel';
    elseif ( $monitor->CanGainAbs() )
      $cmds['GainRoot'] = 'gainAbs';
    $cmds['GainUp'] = $cmds['GainRoot'].'Up';
    $cmds['GainDown'] = $cmds['GainRoot'].'Down';
    $cmds['GainAuto'] = 'gainAuto';
    $cmds['GainMan'] = 'gainMan';
  }

  if ( $monitor->CanMove() ) {
    if ( $monitor->CanMoveCon() ) {
      $cmds['MoveRoot'] = 'moveCon';
      $cmds['Center'] = 'moveStop';
    } elseif ( $monitor->CanMoveRel() ) {
      $cmds['MoveRoot'] = 'moveRel';
      $cmds['Center'] = $cmds['PresetHome'];
    } elseif ( $monitor->CanMoveAbs() ) {
      $cmds['MoveRoot'] = 'moveAbs';
      $cmds['Center'] = $cmds['PresetHome'];
    } else {
      $cmds['MoveRoot'] = '';
    }

    $cmds['MoveUp'] = $cmds['MoveRoot'].'Up';
    $cmds['MoveDown'] = $cmds['MoveRoot'].'Down';
    $cmds['MoveLeft'] = $cmds['MoveRoot'].'Left';
    $cmds['MoveRight'] = $cmds['MoveRoot'].'Right';
    $cmds['MoveUpLeft'] = $cmds['MoveRoot'].'UpLeft';
    $cmds['MoveUpRight'] = $cmds['MoveRoot'].'UpRight';
    $cmds['MoveDownLeft'] = $cmds['MoveRoot'].'DownLeft';
    $cmds['MoveDownRight'] = $cmds['MoveRoot'].'DownRight';
  }
  return( $cmds );
}

function controlFocus( $monitor, $cmds ) {
  ob_start();
?>
<div class="arrowControl focusControls">
  <div class="arrowLabel"><?php echo translate('Near') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['FocusNear'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $monitor->CanFocusCon() ) { ?> onclick="controlCmd('<?php echo $cmds['FocusStop'] ?>')"<?php } ?>><?php echo translate('Focus') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['FocusFar'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Far') ?></div>
<?php
  if ( $monitor->CanAutoFocus() ) {
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

function controlZoom( $monitor, $cmds ) {
  global $SLANG;

  ob_start();
?>
<div class="arrowControl zoomControls">
  <div class="arrowLabel"><?php echo translate('Tele') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['ZoomTele'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $monitor->CanZoomCon() ) { ?> onclick="controlCmd('<?php echo $cmds['ZoomStop'] ?>')"<?php } ?>><?php echo translate('Zoom') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['ZoomWide'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Wide') ?></div>
<?php
  if ( $monitor->CanAutoZoom() ) {
?>
  <button type="button" class="ptzTextBtn" value="Auto" onclick="controlCmd('<?php echo $cmds['ZoomAuto'] ?>')"><?php echo translate('Auto') ?></button>
  <button type="button" class="ptzTextBtn" value="Man" onclick="controlCmd('<?php echo $cmds['ZoomMan'] ?>')"><?php echo translate('Man') ?></button>
<?php
  }
?>
</div><?php
  return ob_get_clean();
}

function controlIris( $monitor, $cmds ) {
  global $SLANG;

  ob_start();
?>
<div class="arrowControl irisControls">
  <div class="arrowLabel"><?php echo translate('Open') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['IrisOpen'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $monitor->CanIrisCon() ) { ?> onclick="controlCmd('<?php echo $cmds['IrisStop'] ?>')"<?php } ?>><?php echo translate('Iris') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['IrisClose'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Close') ?></div>
<?php
  if ( $monitor->CanAutoIris() ) {
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

function controlWhite( $monitor, $cmds ) {
  global $SLANG;

  ob_start();
?>
<div class="arrowControl whiteControls">
  <div class="arrowLabel"><?php echo translate('In') ?></div>
  <button type="button" class="longArrowBtn upBtn" onclick="controlCmd('<?php echo $cmds['WhiteIn'] ?>',event,0,-1)"></button>
  <button type="button" class="arrowCenter"<?php if ( $monitor->CanWhiteCon() ) { ?> onclick="controlCmd('<?php echo $cmds['WhiteStop'] ?>')"<?php } ?>><?php echo translate('White') ?></button>
  <button type="button" class="longArrowBtn downBtn" onclick="controlCmd('<?php echo $cmds['WhiteOut'] ?>',event,0,1)"></button>
  <div class="arrowLabel"><?php echo translate('Out') ?></div>
<?php
  if ( $monitor->CanAutoWhite() ) {
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

function controlPanTilt( $monitor, $cmds ) {
  global $SLANG;

  ob_start();
?>
<div class="pantiltControls">
  <div class="pantiltLabel"><?php echo translate('PanTilt') ?></div>
  <div class="pantiltButtons">
<?php
  $hasPan = $monitor->CanPan();
  $hasTilt = $monitor->CanTilt();
  $hasDiag = $hasPan && $hasTilt && $monitor->CanMoveDiag();
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

function controlPresets( $monitor, $cmds ) {
  global $SLANG;

  // MAX_PRESETS IS PER LINE
  define( 'MAX_PRESETS', '12' );

  $sql = 'SELECT * FROM ControlPresets WHERE MonitorId = ?';
  $labels = array();
  foreach( dbFetchAll( $sql, NULL, array( $monitor->Id() ) ) as $row ) {
    $labels[$row['Preset']] = $row['Label'];
  }

  $presetBreak = (int)(($monitor->NumPresets()+1)/((int)(($monitor->NumPresets()-1)/MAX_PRESETS)+1));

  ob_start();
?>
<div class="presetControls">
  <!--<div><?php echo translate('Presets') ?></div>-->
  <div>
<?php
  for ( $i = 1; $i <= $monitor->NumPresets(); $i++ ) {
    ?>
      <button type="button" class="ptzNumBtn" title="<?php echo isset($labels[$i])?htmlentities($labels[$i]):'' ?>" value="<?php echo $i ?>" onclick="controlCmd('<?php echo $cmds['PresetGoto'] ?><?php echo $i ?>');"/><?php echo $i ?></button>
<?php
    if ( $i && (($i%$presetBreak) == 0) ) {
?><br/><?php
    }
  } // end foreach preset
?>
  </div>
  <div>
<?php
  if ( $monitor->HasHomePreset() ) {
?>
    <button type="button" class="ptzTextBtn" value="Home" onclick="controlCmd('<?php echo $cmds['PresetHome'] ?>');"><?php echo translate('Home') ?></button>
<?php
  }
  if ( canEdit('Monitors') && $monitor->CanSetPresets() ) {
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

function controlPower( $monitor, $cmds ) {
  global $SLANG;

  ob_start();
?>
<div class="powerControls">
  <div class="powerLabel"><?php echo translate('Control') ?></div>
  <div>
<?php
  if ( $monitor->CanWake() ) {
?>
    <button type="button" class="ptzTextBtn" value="Wake" onclick="controlCmd('<?php echo $cmds['Wake'] ?>')"><?php echo translate('Wake') ?></button>
<?php
  }
  if ( $monitor->CanSleep() ) {
?>
    <button type="button" class="ptzTextBtn" value="Sleep" onclick="controlCmd('<?php echo $cmds['Sleep'] ?>')"><?php echo translate('Sleep') ?></button>
<?php
  }
  if ( $monitor->CanReset() ) {
?>
    <button type="button" class="ptzTextBtn" value="Reset" onclick="controlCmd('<?php echo $cmds['Reset'] ?>')"><?php echo translate('Reset') ?></button>
<?php
  }
  if ( $monitor->CanReboot() ) {
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

function ptzControls( $monitor ) {
  $cmds = getControlCommands($monitor);
  ob_start();
?>
<div class="controlsPanel">
<?php
  if ( $monitor->CanFocus() )
    echo controlFocus($monitor, $cmds);
  if ( $monitor->CanZoom() )
    echo controlZoom($monitor, $cmds);
  if ( $monitor->CanIris() )
    echo controlIris($monitor, $cmds);
  if ( $monitor->CanWhite() )
    echo controlWhite($monitor, $cmds);
  if ( $monitor->CanMove() ) {
?>
  <div class="pantiltPanel">
<?php echo controlPanTilt($monitor, $cmds); ?>
  </div>
<?php
  }
  if ( $monitor->CanWake() || $monitor->CanSleep() || $monitor->CanReset() )
    echo controlPower($monitor, $cmds);
  if ( $monitor->HasPresets() )
    echo controlPresets($monitor, $cmds);
?>
</div>
<?php
  return ob_get_clean();
}
?>
