<div class="main-page-cmmn-feed-card__footer--social-icons">
       @if($favRow['like'] == 1)
              <a href="javascript:void(0)" class="likeOppBtn{{$favRow['oid']}}" data-action="unlike"  data-oid="{{$favRow['oid']}}"><i class="fas fa-thumbs-up"></i></a>
       @else
               <a href="javascript:void(0)" class="likeOppBtn{{$favRow['oid']}}" data-action="like"  data-oid="{{$favRow['oid']}}"><i class="far fa-thumbs-up"></i></a>
       @endif

       @if($favRow['favourite'] == 1)
              <a href="javascript:void(0)" class="favOppBtn{{$favRow['oid']}}" data-action="unfav"  data-oid="{{$favRow['oid']}}"><i class="fas fa-heart"></i></a>
       @else
              <a href="javascript:void(0)" class="favOppBtn{{$favRow['oid']}}" data-action="fav"  data-oid="{{$favRow['oid']}}"> <i class="far fa-heart"></i></a>
       @endif
      
      <i class="far fa-comment"></i>
      <a href="#mainPage__sharetoExpert" class="shareBtn{{$favRow['oid']}}" data-remote="{{ url('share-feed', Crypt::encrypt($favRow['oid'])) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="OPP"><i class="far fa-share-square"></i></a> 
</div>
