<?php

if ( empty($_REQUEST['eid']) ) ajaxError('Event Id Not Provided');
if ( empty($_REQUEST['fid']) ) ajaxError('Frame Id Not Provided');

$eid = $_REQUEST['eid'];
$fid = $_REQUEST['fid'];
$row = ( isset($_REQUEST['row']) ) ? $_REQUEST['row'] : '';
$raw = isset($_REQUEST['raw']);
$data = array();

// Not sure if this is required
if ( ZM_OPT_USE_AUTH && (ZM_AUTH_RELAY == 'hashed') ) {
  $auth_hash = generateAuthHash(ZM_AUTH_HASH_IPS);
  if ( isset($_REQUEST['auth']) and ($_REQUEST['auth'] != $auth_hash) ) {
    $data['auth'] = $auth_hash;
  }
}

if ( $raw ) {
  $sql = 'SELECT S.*,E.*,Z.Name AS ZoneName,Z.Units,Z.Area,M.Name AS MonitorName FROM Stats AS S LEFT JOIN Events AS E ON S.EventId = E.Id LEFT JOIN Zones AS Z ON S.ZoneId = Z.Id LEFT JOIN Monitors AS M ON E.MonitorId = M.Id WHERE S.EventId = ? AND S.FrameId = ? ORDER BY S.ZoneId';
  $stat = dbFetchOne( $sql, NULL, array( $eid, $fid ) );
  if ( $stat ) {
    $stat['ZoneName'] = validHtmlStr($stat['ZoneName']);
    $stat['PixelDiff'] = validHtmlStr($stat['PixelDiff']);
    $stat['AlarmPixels'] = sprintf( "%d (%d%%)", $stat['AlarmPixels'], (100*$stat['AlarmPixels']/$stat['Area']) );
    $stat['FilterPixels'] = sprintf( "%d (%d%%)", $stat['FilterPixels'], (100*$stat['FilterPixels']/$stat['Area']) );
    $stat['BlobPixels'] = sprintf( "%d (%d%%)", $stat['BlobPixels'], (100*$stat['BlobPixels']/$stat['Area']) );
    $stat['Blobs'] = validHtmlStr($stat['Blobs']);
    if ( $stat['Blobs'] > 1 ) {
      $stat['BlobSizes'] = sprintf( "%d-%d (%d%%-%d%%)", $stat['MinBlobSize'], $stat['MaxBlobSize'], (100*$stat['MinBlobSize']/$stat['Area']), (100*$stat['MaxBlobSize']/$stat['Area']) );
    } else {
      $stat['BlobSizes'] = sprintf( "%d (%d%%)", $stat['MinBlobSize'], 100*$stat['MinBlobSize']/$stat['Area'] );
    }
    $stat['AlarmLimits'] = validHtmlStr($stat['MinX'].",".$stat['MinY']."-".$stat['MaxX'].",".$stat['MaxY']);
  }
  $data['raw'] = $stat;
} else {
  $data['html'] = getStatsTableHTML($eid, $fid, $row);
  $data['id'] = '#contentStatsTable' .$row;
}

ajaxResponse($data);
return;
?>
