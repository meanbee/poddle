<ul class="rss-list rss-new">
    @foreach($newRss as $rss)
        <li class="rss-item">
            <a class="rss-name" href="{{ route('rss.view', ['id' => $rss->getId(), 'slug' => $rss->getSlug()]) }}">{{ $rss->name }}</a>
            <span class="rss-created-date">{{ $rss->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
