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
    <h2>Generate New Short URL</h2>
    <a href="/">Dashboard</a>
<form action="/generateurl" method="post">
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
    <label for="long_url"><b>Long URL</b></label>
    <input type="text" placeholder="Enter Long URL" style="width: 80%;" name="long_url" required>
<br><br>
   

    <button type="submit">Generate Short URL</button>
   


</form>
</div>