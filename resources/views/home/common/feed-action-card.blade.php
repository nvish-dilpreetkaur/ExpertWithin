<div class="main-page-cmmn-feed-card__footer--social-icons">
      @if($feedVal->liked_feed == 1)
            <a href="javascript:void(0)" class="likeBtn{{$feedVal->id}}" data-action="unlike"  data-feed_id="{{$feedVal->id}}"><i class="fas fa-thumbs-up"></i></a>
      @else
             <a href="javascript:void(0)" class="likeBtn{{$feedVal->id}}" data-action="like"  data-feed_id="{{$feedVal->id}}"><i class="far fa-thumbs-up"></i></a>
      @endif

      @if($feedVal->marked_as_fav == 1)
             <a href="javascript:void(0)" class="favBtn{{$feedVal->id}}" data-action="unfav"  data-feed_id="{{$feedVal->id}}"><i class="fas fa-heart"></i></a>
      @else
             <a href="javascript:void(0)" class="favBtn{{$feedVal->id}}" data-action="fav"  data-feed_id="{{$feedVal->id}}"> <i class="far fa-heart"></i></a>
      @endif
      
      <i class="far fa-comment"></i>
      <i class="far fa-share-square"></i>
</div>