<div class="main-page-cmmn-feed-card__footer--social-icons">
       @if($likeVal->like == 1)
              <a href="javascript:void(0)" class="likeOppBtn{{$likeVal->id}}" data-action="unlike"  data-oid="{{$likeVal->id}}"><i class="fas fa-thumbs-up"></i></a>
       @else
               <a href="javascript:void(0)" class="likeOppBtn{{$likeVal->id}}" data-action="like"  data-oid="{{$likeVal->id}}"><i class="far fa-thumbs-up"></i></a>
       @endif

       @if($likeVal->favourite == 1)
              <a href="javascript:void(0)" class="favOppBtn{{$likeVal->id}}" data-action="unfav"  data-oid="{{$likeVal->id}}"><i class="fas fa-heart"></i></a>
       @else
              <a href="javascript:void(0)" class="favOppBtn{{$likeVal->id}}" data-action="fav"  data-oid="{{$likeVal->id}}"> <i class="far fa-heart"></i></a>
       @endif
      
      <i class="far fa-comment"></i>
      <a href="#mainPage__sharetoExpert" class="shareBtn{{$likeVal->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($likeVal->id)) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="OPP"><i class="far fa-share-square"></i></a> 
</div>
