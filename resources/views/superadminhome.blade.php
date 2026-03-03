<style>::after {
  box-sizing: border-box;
}
body {
  font-family: Arial, Helvetica, sans-serif;
}
.container {
  padding: 16px;
  border: 1px solid #ccc;
  margin: 30px auto;
  width: 50%;
}
.left {
  float: left;
}
.right {
  float: right;
}
.clear {
  clear: both;
  margin-top: 15px;
}
.w33 {
  width: 33%;
}
</style>
<div class="container">
<div class="clear">
    <div class="left">{{ Auth::user()->name }} Dashboard</div>
    <div class="right"><a href="/logout">Logout</a></div>
</div>
   <div class="clear" style="border-top: 1px solid #ccc; margin-top: 20px; padding-top: 10px;">
    <div class="left w33">Clients</div>
    <div class="left w33"><a href="/generated-urls">Generated URLs</a></div>
    <div class="right">
        <a href="/invite">Invite</a>
    </div>
    
</div>

    <table style="width: 100%; border-collapse: collapse;" border="1">
        <tr>
            <th>Client Name</th>
            <th>Users</th>
            <th>Total generated URL</th>
            <th>Total Url Hits</th>
        </tr>
        @foreach($companies as $company)
         <tr>
            <td>{{ $company->name }} <br> <i>{{ $company->email }}</i></td>
            <td>{{ $company->users }}</td>
            <td>{{ $company->total_urls }}</td>
            <td>{{ $company->total_hits }}</td>
        
        </tr>
        @endforeach
    </table>
    @if($companies->count() == 0)
    <p>No clients yet.</p>
    @else
    <p>Total Clients: {{ $companies->count() }}</p>
    @endif
</div>