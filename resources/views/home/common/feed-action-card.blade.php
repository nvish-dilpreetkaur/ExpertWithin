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
       <a href="#mainPage__sharetoExpert" class="shareBtn{{$feedVal->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($feedVal->id)) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="feed"><i class="far fa-share-square"></i></a> 
       <?php /* <a href="javascript:void(0)" class="shareBtn{{$feedVal->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($feedVal->id)) }}"  ><i class="far fa-share-square"></i></a>*/ ?>
</div>