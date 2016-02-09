<ul class="podcast-episodes-list podcast-episodes-recent">
    @foreach($recentPodcasts as $podcast)
        <li class="podcast-episode-item">
            <a class="podcast-episode-link" href="{{ route('podcast.view', ['id' => $podcast->getId(), 'slug' => $podcast->getSlug()]) }}">{{ $podcast->episode_name }}</a>
            <p class="podcast-episode-name">{{ $podcast->podcast_name }}</p>
            <span class="podcast-episode-published-date">{{ $podcast->published_date->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
