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
</style>
<div class="container">
    <h2>Invite New Client</h2>
    <p><a href="/">Dashboard</a></p>
<form action="/invite" method="post">
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
@csrf
    <label for="client_name"><b>Clinet Name</b></label>
    <input type="text" placeholder="Enter Client Name" name="client_name" required>
<br><br>
    <label for="uname"><b>Client Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>
<br><br>
@if(Auth::user()->role === 'admin')
  <label for="uname"><b>Role</b></label>
<select name="role" required>
    <option value="admin">Admin</option>
    <option value="member">Member</option>
</select>
  <br><br>
  @elseif(Auth::user()->role === 'super_admin')
  <input type="hidden" name="role" value="admin">
@endif
    <button type="submit">Invite Client</button>
   


</form>
</div>