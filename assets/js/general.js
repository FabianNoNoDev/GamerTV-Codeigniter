
$('#myTabs a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$(document).ready(function() {
    $('#top100').DataTable( {
        "paging":   false,
        "searching": false,
        "order": [[ 3, "desc" ]],
        "info":     false
    } );
} );