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
    <div class="left">
          @if(Auth::user()->role === 'admin')
        <a href="/teammembers">Team Members</a>
        @endif
    </div>
    <div class="right">
        @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
        <a href="/invite">Invite</a>
        @endif
    </div>
    
</div>

 <div class="clear">
    <div class="left w33">Generated Short URLs</div>
     @if(Auth::user()->role === 'super_admin')
    <div class="left w33"><a href="./">Dashboard</a></div>
    @else
    <div class="left w33"><a href="/generateurl">Generate</a></div>
    @endif
    <div class="right w33">
        <form action="/download" method="post" style="display: inline;">
            @csrf
            <select name="filter" id="filter">
                <option value="thismonth">This Month</option>
                <option value="lastmonth">Last Month</option>
                <option value="lastweek">Last Week</option>
                <option value="today">Today</option>
            </select>
            <button type="submit">Download</button>
        </form>
       </div>
</div>
    <table style="width: 100%; border-collapse: collapse;" border="1">
        <tr>
            <th>Short URL</th>
            <th>Long URL</th>
            <th>Hits</th>
            @if(Auth::user()->role === 'super_admin')
            <th>Client Name</th>
            @endif
            <th>Created At</th>
        </tr>
        @foreach($shortUrls as $shortUrl)
        <tr>
            <td><a target="_blank" href="{{ url("/s/{$shortUrl->code}") }}">{{ url("/s/{$shortUrl->code}") }}</a></td>
            <td>{{ $shortUrl->url }}</td>
            <td>{{ $shortUrl->hits }}</td>
            @if(Auth::user()->role === 'super_admin')
            <td>{{ $shortUrl->company->name }}</td>
            @endif
            <td>{{ $shortUrl->created_at }}</td>
        </tr>
        @endforeach
    </table>
    @if($shortUrls->count() == 0)
    <p>No URLs generated yet.</p>
    @else
    <p>Total URLs: {{ $shortUrls->count() }}</p>
    @endif
</div>