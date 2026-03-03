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
    <h2>Login Form</h2>
<form action="/login" method="post">
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@csrf
    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>
<br><br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
<br><br>
    <button type="submit">Login</button>
   


</form>
</div>