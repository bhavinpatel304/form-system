<div class="tabsInner pagesUl">
   <ul class="nav nav-tabs sortableUl" id="backend-pill" role="tablist">
      <li class="nav-item transparentDiv mobile-active unsortable">
         <a class="nav-link active" id="primary-tab" data-toggle="tab" href="#primary"
            role="tab" aria-controls="home" aria-selected="true">Primary Details</a>
      </li>
      <li class="nav-item unsortable">
         <a class="nav-link" id="welcome-tab" data-toggle="tab" href="#welcome" role="tab"
            aria-controls="profile" aria-selected="false">Welcome</a>
      </li>

      @if(\Request::route()->getName() == "editsurvey" )
         <?php $pageI = 1;?>
         
        @foreach($pages as $page)
        
         <li class="nav-item pageClasses" data-page-id="{{ $page }}" >
            <?php if($pageI == 1 ){ ?>

               <?php if(count($pages) == 1) { ?>
                     <a class="nav-link" id="page-tab-{{ $page }}" data-toggle="tab" href="#page{{ $page }}" role="tab"
                  aria-controls="profile" aria-selected="false">Page {{ $page }} </a>
               <?php } else { ?>
                     <a class="nav-link" id="page-tab-{{ $page }}" data-toggle="tab" href="#page{{ $page }}" role="tab"
            aria-controls="profile" aria-selected="false">Page {{ $page }} &nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" data-remove-page-id="{{ $page }}" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete Page"></i></a>
               <?php } ?>
         
            <?php }else { ?>
               <a class="nav-link" id="page-tab-{{ $page }}" data-toggle="tab" href="#page{{ $page }}" role="tab"
            aria-controls="profile" aria-selected="false">Page {{ $page }} &nbsp;&nbsp;&nbsp; <i class="fa fa-times deletePage" data-remove-page-id="{{ $page }}" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete Page"></i></a>
            <?php } ?>
         </li>
         <?php $pageI++;?>
         @endforeach

      @else

      <li class="nav-item pageClasses" data-page-id="1" >
            <a class="nav-link" id="page-tab-1" data-toggle="tab" href="#page1" role="tab"
               aria-controls="profile" aria-selected="false">Page 1</a>
         </li>
      
      @endif


      {{-- <li class="nav-item">
         <a class="nav-link" id="page-tab" data-toggle="tab" href="#page2" role="tab"
            aria-controls="profile" aria-selected="false">Page 2</a>
      </li> --}}
      <!-- Add Page-->
      <li class="nav-item add-page unsortable">
         <a class="add-new-page" data-toggle="tooltip" data-placement="right" title="Add Page" href="javascript:void(0)">
         <i class="fa fa-plus" aria-hidden="true"></i>
         </a>
         {{-- <span class="add-new-page" >
         <i class="fa fa-plus" aria-hidden="true"></i>
         </span> --}}
      </li>

      <!-- Add Page-->
   </ul>
</div>
<div class="previewBtn">
   
      <button type="button" style="display:none"  class="btn btn-secondary  btn-s-sm waves-effect waves-light m-1" disabled id="btnpreview">Preview</button>

    @if(\Request::route()->getName() == "editsurvey" )
      @if($checkSurveyFilled == '0')      
         <button type="submit" class="btn btn-br-success btn-s-sm waves-effect waves-light m-1 surveySaveSubmitBtn surveyEditSubmitBtn">Save</button>
      @else 
      <button type="submit" class="btn btn-br-success btn-s-sm waves-effect waves-light m-1 surveySaveSubmitBtn surveyEditSubmitBtn">Save</button>
         {{-- <button type="button" class="btn btn-br-success btn-s-sm waves-effect waves-light m-1 surveySaveFilled">Save</button> --}}
      @endif
      
   @else    
      <button type="submit" class="btn btn-br-success btn-s-sm waves-effect waves-light m-1">Save</button>
   @endif

   

</div>