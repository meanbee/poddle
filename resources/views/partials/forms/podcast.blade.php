<form method="post" action="{{ route('podcast.submit') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label>Podcast Name</label>
        <input type="text" name="podcast_name" class="form-control" placeholder="Episode Name"/>
    </div>

    <div class="form-group">
        <label>Episode Name</label>
        <input type="text" name="episode_name" class="form-control" placeholder="Episode Name"/>
    </div>

    <div class="form-group">
        <label>Link to Podcast</label>
        <input type="text" name="url" class="form-control" placeholder="Link to Podcast"/>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit Podcast"/>
    </div>
</form>
