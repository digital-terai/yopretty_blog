<div id="news-sharer">
    <div class="share-links">
        <span class="mr5">{!! trans('website.news.share_on') !!}</span>
        <a class="facebook" href="https://www.facebook.com/sharer.php?u={{ $news->getPermalink() }}" title="Facebook" target="_blank">
              {{icon('facebook')}}
        </a>
        <a class="google-plus" href="https://plus.google.com/share?url={{ $news->getPermalink() }}" title="Google Plus" target="_blank">
            {{icon('google-plus')}}
        </a>
        <a class="invia-ad-un-amico" href="mailto:?subject={{ $news->title }}&body={{ $news->getPermalink() }}" title="Email">
            {{icon('envelope')}}
        </a>
    </div>
</div>
