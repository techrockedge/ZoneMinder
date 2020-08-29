function thumbnail_onmouseover(event) {
  var img = event.target;
  img.src = '';
  img.src = img.getAttribute('stream_src');
}

function thumbnail_onmouseout(event) {
  var img = event.target;
  img.src = '';
  img.src = img.getAttribute('still_src');
}

function initThumbAnimation() {
  $j('.colThumbnail img').each(function() {
    this.addEventListener('mouseover', thumbnail_onmouseover, false);
    this.addEventListener('mouseout', thumbnail_onmouseout, false);
  });
}

// Returns the event id's of the selected rows
function getIdSelections() {
  var table = $j('#eventTable');

  return $j.map(table.bootstrapTable('getSelections'), function(row) {
    return row.Id.replace(/(<([^>]+)>)/gi, ''); // strip the html from the element before sending
  });
}

// Returns a boolen to indicate at least one selected row is archived
function getArchivedSelections() {
  var table = $j('#eventTable');
  var selection = $j.map(table.bootstrapTable('getSelections'), function(row) {
    return row.Archived;
  });
  return selection.includes("Yes");
}

function initPage() {
  var backBtn = $j('#backBtn');
  var viewBtn = $j('#viewBtn');
  var archiveBtn = $j('#archiveBtn');
  var unarchiveBtn = $j('#unarchiveBtn');
  var editBtn = $j('#editBtn');
  var exportBtn = $j('#exportBtn');
  var downloadBtn = $j('#downloadBtn');
  var deleteBtn = $j('#deleteBtn');
  var table = $j('#eventTable');

  // Define the icons used in the bootstrap-table top-right toolbar
  var icons = {
    paginationSwitchDown: 'fa-caret-square-o-down',
    paginationSwitchUp: 'fa-caret-square-o-up',
    export: 'fa-download',
    refresh: 'fa-sync',
    toggleOff: 'fa-toggle-off',
    toggleOn: 'fa-toggle-on',
    columns: 'fa-th-list',
    fullscreen: 'fa-arrows-alt',
    detailOpen: 'fa-plus',
    detailClose: 'fa-minus'
  };

  // Init the bootstrap-table
  table.bootstrapTable('destroy').bootstrapTable({icons: icons});

  // Hide these columns on first run when no cookie is saved
  if ( !getCookie("zmEventsTable.bs.table.columns") ) {
    table.bootstrapTable('hideColumn', 'Archived');
    table.bootstrapTable('hideColumn', 'Emailed');
  }

  // enable or disable buttons based on current selection and user rights
  table.on('check.bs.table uncheck.bs.table ' +
  'check-all.bs.table uncheck-all.bs.table',
  function() {
    selections = table.bootstrapTable('getSelections');

    viewBtn.prop('disabled', !(selections.length && canViewEvents));
    archiveBtn.prop('disabled', !(selections.length && canEditEvents));
    unarchiveBtn.prop('disabled', !(getArchivedSelections()) && canEditEvents);
    editBtn.prop('disabled', !(selections.length && canEditEvents));
    exportBtn.prop('disabled', !(selections.length && canViewEvents));
    downloadBtn.prop('disabled', !(selections.length && canViewEvents));
    deleteBtn.prop('disabled', !(selections.length && canEditEvents));
  });

  // Don't enable the back button if there is no previous zm page to go back to
  backBtn.prop('disabled', !document.referrer.length);

  // Setup the thumbnail video animation
  initThumbAnimation();

  // Some toolbar events break the thumbnail animation, so re-init eventlistener
  table.on('all.bs.table', initThumbAnimation);

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

  // Manage the TIMELINE Button
  document.getElementById("tlineBtn").addEventListener("click", function onTlineClick(evt) {
    evt.preventDefault();
    window.location.assign('?view=timeline'+filterQuery);
  });

  // Manage the VIEW button
  document.getElementById("viewBtn").addEventListener("click", function onViewClick(evt) {
    var selections = getIdSelections();

    evt.preventDefault();
    var filter = '&filter[Query][terms][0][attr]=Id&filter[Query][terms][0][op]=%3D%5B%5D&filter[Query][terms][0][val]='+selections.join('%2C');
    window.location.href = thisUrl+'?view=event&eid='+selections[0]+filter+sortQuery+'&page=1&play=1';
  });

  // Manage the ARCHIVE button
  document.getElementById("archiveBtn").addEventListener("click", function onArchiveClick(evt) {
    var selections = getIdSelections();

    evt.preventDefault();
    $j.getJSON(thisUrl + '?view=events&action=archive&eids[]='+selections.join('&eids[]='));
    window.location.reload(true);
  });

  // Manage the UNARCHIVE button
  document.getElementById("unarchiveBtn").addEventListener("click", function onUnarchiveClick(evt) {
    if ( ! canEditEvents ) {
      alert("You do not have permission to Unarchive events.");
      return;
    }

    var selections = getIdSelections();
    console.log(selections);

    evt.preventDefault();
    $j.getJSON(thisUrl + '?view=events&action=unarchive&eids[]='+selections.join('&eids[]='));

    if ( openFilterWindow ) {
      //opener.location.reload(true);
      createPopup( '?view=filter&page='+thisPage+filterQuery, 'zmFilter', 'filter' );
      location.replace( '?view='+currentView+'&page='+thisPage+filterQuery );
    } else {
      window.location.reload(true);
    }
  });

  // Manage the EDIT button
  document.getElementById("editBtn").addEventListener("click", function onEditClick(evt) {
    if ( ! canEditEvents ) {
      alert("You do not have permission to edit events.");
      return;
    }

    var selections = getIdSelections();

    evt.preventDefault();
    createPopup('?view=eventdetail&eids[]='+selections.join('&eids[]='), 'zmEventDetail', 'eventdetail');
  });

  // Manage the EXPORT button
  document.getElementById("exportBtn").addEventListener("click", function onExportClick(evt) {
    var selections = getIdSelections();

    evt.preventDefault();
    window.location.assign('?view=export&eids[]='+selections.join('&eids[]='));
  });

  // Manage the DOWNLOAD VIDEO button
  document.getElementById("downloadBtn").addEventListener("click", function onDownloadClick(evt) {
    var selections = getIdSelections();

    evt.preventDefault();
    createPopup('?view=download&eids[]='+selections.join('&eids[]='), 'zmDownload', 'download');
  });

  // Manage the DELETE button
  document.getElementById("deleteBtn").addEventListener("click", function onDeleteClick(evt) {
    if ( ! canEditEvents ) {
      alert("You do not have permission to delete events.");
      return;
    }

    evt.preventDefault();
    $j('#deleteConfirm').modal('show');
  });

  // Manage the DELETE CONFIRMATION modal button
  document.getElementById("delConfirmBtn").addEventListener("click", function onDelConfirmClick(evt) {
    if ( ! canEditEvents ) {
      alert("You do not have permission to delete events.");
      return;
    }

    var selections = getIdSelections();

    evt.preventDefault();
    $j.getJSON(thisUrl + '?view=events&action=delete&eids[]='+selections.join('&eids[]='));
    window.location.reload(true);
  });

  // Manage the CANCEL modal button
  document.getElementById("delCancelBtn").addEventListener("click", function onDelCancelClick(evt) {
    $j('#deleteConfirm').modal('hide');
  });

  // The table is initially given a hidden style, so now that we are done rendering, show it
  table.show();
}

$j(document).ready(function() {
  initPage();
});
