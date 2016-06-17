<% require css(silverstripe-versioneddataobjects/css/history.css) %>

<div class="history-panel">
<h3>History</h3>

<table class="history-list">

<thead>
<tr>
<th>Ver</th><th>Status</th><th>Published by</th><th>Author</th><th>Updated on</th><th>Select</th>
</tr>
</thead>

<tbody>
<% loop $historyList %>
<tr>
<td>$version</td> <td>$published_status</td> <td>$published_by</td> <td>$authored_by</td> <td>$updated_on</td>
<td><% if not $is_selected %><a href="$Up.url/$version">Select</a><% end_if %></td>
</tr>
<% end_loop %>
</tbody>

</table>
</div>

<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
  $('#action_goRollback').click(function(e) {
  	return confirm('Rollback to this version?');
  	});
});
</script>
