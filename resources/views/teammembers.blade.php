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
    <div class="left w33"><a href="/generateurl">Generate</a></div>
    <div class="right w33">
</div>
</div>
    <table style="width: 100%; border-collapse: collapse;" border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Total Generated URLs</th>
            <th>Total Url Hits</th>
        </tr>
        @foreach($members as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->role }}</td>
            <td>{{ $member->total_urls }}</td>
            <td>{{ $member->total_hits }}</td>
        </tr>
        @endforeach
    </table>
</div>