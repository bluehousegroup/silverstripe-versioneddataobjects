<% require css(silverstripe-versioneddataobjects/css/history.css) %>
<% require javascript(silverstripe-versioneddataobjects/javascript/history.js) %>

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
<td><% if not $is_selected %><a class="select-version" data-vid="$version" href="">Select</a><% end_if %></td>
</tr>
<% end_loop %>
</tbody>

</table>
</div>
<input id="vid" name="vid" type="hidden">
