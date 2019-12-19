<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<style>
      

</style>
<div class="for-invite-user__modal-popup">
<div class="modal-body">
      <form id="shareForm" method="POST"  action="{{ url('share-feed') }}" class="" novalidate>
      <div class="main-page__form-buttons">
                  <button type="submit" class="btn btn-primary">Share</button>
            </div>
      <div  id="vueComponent" class=" ">
                        <input type="text" v-model="search" placeholder="Search title.."/>
                        <!--div contenteditable="true" v-model="search">su
                              </div-->
                             
                        <div class="">
                        <div class="user-invite-textarea-pills">     
                              <ul id="example-2">
                                    <li v-for="item in selectedList">
                                          <a href="javascript:void(0)"><i class="fas fa-times" aria-hidden="true" v-on:click="removeRecord(item)"></i>@{{ item.firstName }}</a>
                                    </li>
                              </ul>
                        </div>

                        <input type="hidden" id="checkedUsers" name="checkedUsers" value=""/>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback"  id="error-checkedUsers"></div>

                        <div class="invite-user-list__all">
                        <ul id="example-1">
                              <li v-for="item in filteredList">
                                    <a href="javascript:void(0)" v-on:click="selectRecord(item)">
                                    @{{ item.firstName }}
                                    </a>
                              </li>
                        </ul>
                        
                              <div v-if="!filteredList.length">
                                    No matched users found.
                              </div>
                         </div>
                        @csrf
				<!--input type="hidden"id="checkedUsers" name="checkedUsers" value=""/-->
                        <input type="hidden" name="share_type" value="{{ $share_type }}">
                        <input type="hidden" name="key_id" value="{{ $key_id }}">
                       
                        </div> 
            </div> 
            <!-- <div class="main-page__form-buttons">
                  <button type="submit" class="btn btn-primary">Share</button>
            </div> -->
      </form>   
</div>
</div>
<script type="text/javascript">
     
</script>