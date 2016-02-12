<ul class="podcast-episodes-list podcast-episodes-recent">
    @foreach($recentPodcasts as $podcast)
        <li class="podcast-episode-item">
            @if (!isset($hideName) || isset($hideName) && !$hideName)
                <p class="podcast-episode-name">{{ $podcast->getPodcastName() }}</p>
            @endif

            @if ($podcast->getPublishedDate())
            <span class="podcast-episode-published-date">{{ $podcast->getPublishedDate()->diffForHumans() }}</span>
            @endif
                
            <a class="podcast-episode-link" href="{{ route('podcast.view', ['id' => $podcast->getId(), 'slug' => $podcast->getSlug()]) }}">{{ $podcast->getEpisodeName() }}</a>
        </li>
    @endforeach
</ul>
