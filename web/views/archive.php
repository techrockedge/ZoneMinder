<?php
//
// ZoneMinder file view file, $Date: 2008-09-29 14:15:13 +0100 (Mon, 29 Sep 2008) $, $Revision: 2640 $
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

if ( !canView('Events') ) {
  $view = 'error';
  return;
}

$archivetype = $_REQUEST['type'];
$connkey = isset($_REQUEST['connkey'])?$_REQUEST['connkey']:'';

if ( $archivetype ) {
  switch ($archivetype) {
  case 'tar.gz':
    $mimetype = 'gzip';
    $file_ext = 'tar.gz';
    break;
  case 'tar':
    $mimetype = 'tar';
    $file_ext = 'tar';
    break;
  case 'zip':
    $mimetype = 'zip';
    $file_ext = 'zip';
    break;
  default:
    $mimetype = NULL;
    $file_ext = NULL;
  }

  if ( $mimetype ) {
    $filename = "zmExport_$connkey.$file_ext";
    $filename_path = ZM_DIR_EXPORTS.'/'.$filename;
    ZM\Logger::Debug("downloading archive from $filename_path");
    if ( is_readable($filename_path) ) {
      header("Content-type: application/$mimetype" );
      header("Content-Disposition: inline; filename=$filename");
      header('Content-Length: ' . filesize($filename_path) );
      set_time_limit(0);
      if ( ! @readfile($filename_path) ) {
        ZM\Error("Error sending $filename_path");
      }
    } else {
      ZM\Error("$filename_path does not exist or is not readable.");
    }
  } else {
    ZM\Error("Unsupported archive type specified. Supported archives are tar and zip");
  }
} else {
  ZM\Error("No archive type given to archive.php. Please specify a tar or zip archive.");
}

?>

