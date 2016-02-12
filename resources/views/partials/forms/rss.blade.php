<form method="post" action="{{ route('rss.submit') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label>RSS Feed</label>
        <input type="text" name="url" class="form-control" placeholder="http://"/>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit"/>
    </div>
</form>
