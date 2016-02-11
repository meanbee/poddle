<ul class="podcast-episodes-list podcast-episodes-recent">
    @foreach($recentPodcasts as $podcast)
        <li class="podcast-episode-item">
            <a class="podcast-episode-link" href="{{ route('podcast.view', ['id' => $podcast->getId(), 'slug' => $podcast->getSlug()]) }}">{{ $podcast->getEpisodeName() }}</a>
            <p class="podcast-episode-name">{{ $podcast->getPodcastName() }}</p>
            <span class="podcast-episode-published-date">{{ $podcast->getPublishedDate()->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
