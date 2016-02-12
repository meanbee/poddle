<h1>Search for a Podcast</h1>

<form action="/search/result" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search for a podcast">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Search"/>
    </div>
</form>

