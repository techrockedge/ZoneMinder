function changeScale() {
  var scale = $j('#scale').val();
  var img = $j('#frameImg');
  var controlsLinks = {
    next: $j('#nextLink'),
    prev: $j('#prevLink'),
    first: $j('#firstLink'),
    last: $j('#lastLink')
  };

  if ( img ) {
    var baseWidth = $j('#base_width').val();
    var baseHeight = $j('#base_height').val();
    if ( ! parseInt(scale) ) {
      var newSize = scaleToFit(baseWidth, baseHeight, img, $j('#controls'));
      newWidth = newSize.width;
      newHeight = newSize.height;
      autoScale = newSize.autoScale;
    } else {
      $j(window).off('resize', endOfResize); //remove resize handler when Scale to Fit is not active
      newWidth = baseWidth * scale / SCALE_BASE;
      newHeight = baseHeight * scale / SCALE_BASE;
    }
    img.css('width', newWidth + 'px');
    img.css('height', newHeight + 'px');
  }
  setCookie('zmWatchScale', scale, 3600);
  $j.each(controlsLinks, function(k, anchor) { //Make frames respect scale choices
    if ( anchor ) {
      anchor.prop('href', anchor.prop('href').replace(/scale=.*&/, 'scale=' + scale + '&'));
    }
  });
}

if ( !scale ) {
  $j(document).ready(changeScale);
}

document.addEventListener('DOMContentLoaded', function onDCL() {
  document.getElementById('scaleControl').addEventListener('change', changeScale);
});

function getStat(params) {
  $j.getJSON(thisUrl + '?view=request&request=stats&raw=true', params)
      .done(function(data) {
        var stat = data.raw;

        $j('#frameStatsTable').empty().append('<tbody>');
        $j.each( statHeaderStrings, function( key ) {
          var th = $j('<th>').addClass('text-right').text(statHeaderStrings[key]);
          var tdString = ( stat ) ? stat[key] : 'n/a';
          var td = $j('<td>').text(tdString);
          var row = $j('<tr>').append(th, td);

          $j('#frameStatsTable tbody').append(row);
        });
      })
      .fail(logAjaxFail);
}

function initPage() {
  var backBtn = $j('#backBtn');

  if ( scale == '0' || scale == 'auto' ) changeScale();

  // Don't enable the back button if there is no previous zm page to go back to
  backBtn.prop('disabled', !document.referrer.length);

  // Manage the BACK button
  document.getElementById("backBtn").addEventListener("click", function onBackClick(evt) {
    evt.preventDefault();
    window.history.back();
  });

  // Manage the REFRESH Button
  document.getElementById("refreshBtn").addEventListener("click", function onRefreshClick(evt) {
    evt.preventDefault();
    window.location.reload(true);
  });

  // Manage the STATS button
  document.getElementById("statsBtn").addEventListener("click", function onViewClick(evt) {
    evt.preventDefault();
    window.location.href = thisUrl+'?view=stats&eid='+eid+'&fid='+fid;
  });

  // Load the frame stats
  getStat({eid: eid, fid: fid});
}

$j(document).ready(function() {
  initPage();
});
