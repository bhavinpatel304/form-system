<div class="block-header">
   <div class="row">
      <div class="col-sm-5 col-xs-12 d-flex align-self-center">
         <h2><?= $data['mainTitle']; ?></h2>
      </div>
      <div class="col-sm-7 col-xs-12 text-right">
         <ul class="breadcrumb pull-right">
            <?php if(!empty($data['isDashboardPage'])){ ?>
            <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"><i class="mdi-action-home "></i> Home</a></li>
            <?php } else { ?>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="mdi-action-home "></i> Home</a></li>
            <li class="breadcrumb-item <?php if(empty($data['breadCrumbSubTitle'])){ ?> active <?php } ?>">
               <?php 
                  $linkUrl = "javascript:void(0)";
                  if(!empty($data['breadCrumbSubTitle'])){ 
                     
                     $linkUrl = route($data['breadCrumbUrl']);
                  }
                  ?>
               <a href="<?= $linkUrl; ?>"> <?= $data['breadCrumbTitle']; ?></a>
            </li>
            <?php if(!empty($data['breadCrumbSubTitle'])){ ?>
            <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $data['breadCrumbSubTitle']; ?></a></li>
            <?php } ?>
            <?php } ?>
         </ul>
      </div>
   </div>
</div>

