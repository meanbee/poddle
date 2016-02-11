<ul class="rss-list rss-new">
    @foreach($newRss as $rss)
        <li class="rss-item">
            <a class="rss-name" href="{{ route('rss.view', ['id' => $rss->getId(), 'slug' => $rss->getSlug()]) }}">{{ $rss->name }}</a>
            <p class="rss-link">{{ $rss->url }}</p>
            <span class="rss-created-date">{{ $rss->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
