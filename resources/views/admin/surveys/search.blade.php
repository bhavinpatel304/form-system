@forelse($surveys as $currSurvey)
<?php
$cardClass = '';
if($currSurvey->status == 2){
//$cardClass = 'disabled-card';
}
?>
<div class="col-xl-3 col-sm-6 col-xs-12 P-10">
	<div class="card survey-card <?= $cardClass; ?>">
		<div class="card-header text-center">
			<h5 class="m-0"><a href="{{route('editsurvey', $currSurvey->id)}}" data-toggle="tooltip" title="{{ $currSurvey->survey_name }}" data-placement="bottom">{{ str_limit($currSurvey->survey_name, $limit = 40, $end = '...') }} </a></h5>
		</div>
		<div class="card-body text-center">
			<div class="company-logo">
				<a href="{{route('editsurvey', $currSurvey->id)}}" >
					@if (!empty($currSurvey->survey_company_logo) && file_exists($survey_company_thumb_path . $currSurvey->survey_company_logo))
					<?php  $imageUrl = url($survey_company_imgUrl) . '/' . $currSurvey->survey_company_logo; ?>
					<img src="<?= url($imageUrl); ?>" id="liveimage" alt="company_logo" data-toggle="tooltip" title="{{ $currSurvey->company_name }}" data-placement="bottom" />
					@elseif (!empty($currSurvey->company_logo) && file_exists($company_thumb_path . $currSurvey->company_logo))
					<?php  $imageUrl = url($imgUrl) . '/' . $currSurvey->company_logo; ?>
					<img src="<?= url($imageUrl); ?>" id="liveimage" alt="company_logo" data-toggle="tooltip" title="{{ $currSurvey->company_name }}" data-placement="bottom" />
					@else
					<img src="{{ url('/images/' . env('DEFAULT_COMPANY_IMAGE','')) }}" id="liveimage" alt="company_logo" data-toggle="tooltip" title="{{ $currSurvey->company_name }}" data-placement="bottom" />
					@endif
				</a>
			</div>
			<div class="ml-auto copySurveyLink">
				<a href="javascript:void(0)" data-id="{{ $currSurvey->id }}" class="copyMe"  data-toggle="tooltip" title="" data-original-title="Copy Survey">
					<i class="fa fa-copy" aria-hidden="true"></i>
				</a>
			</div>
			<div class="ml-auto csvLink">
				<a target="_blank" href="{{route('download-csv', $currSurvey->id)}}" class="" data-toggle="tooltip" title="" data-original-title="Download Survey Report">
					<i class="fa fa-download" aria-hidden="true"></i>
				</a>
			</div>
			<div class="ml-auto surveyLink">
				<a href="javascript:void(0)" data-id="{{ $currSurvey->id }}" class="showLink" data-toggle="tooltip" title="" data-original-title="Survey Link">
					<i class="fa fa-link" aria-hidden="true"></i>
				</a>
			</div>
			<div class="ml-auto closebtn">
				<a href="javascript:void(0)" data-id="{{ $currSurvey->id }}" class="removeMe close " data-toggle="tooltip" title="" data-original-title="Delete Survey">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
		</div>
		<div class="card-fotter">
			<ul class="bottom-icon">
				<li class="invited">
					<a class="link" href="{{route('editsurvey', $currSurvey->id)}}" data-toggle="tooltip" title="" data-original-title="Invited">
						{{-- @if(!empty($currSurvey->max_invitations)) --}}
							<img src="{{ asset('images/icon-1.svg') }}" class="icon" alt="icon" width="16" height="25">
						{{-- @endif --}}
						<span>
							@if(!empty($currSurvey->max_invitations))
								{{ $currSurvey->max_invitations }}
							@else 
									{{ 'N/A' }} 
								@endif
						</span>
					</a>
				</li>
				<li>
					<a class="link" href="{{route('editsurvey', $currSurvey->id)}}" data-toggle="tooltip" title="" data-original-title="Responded">
						<img src="{{ asset('images/icon-2.svg') }}" class="icon" alt="icon" width="18" height="25">
						<span>{{ $currSurvey->total_responded }}</span>
					</a>
				</li>
				<li>
					<a class="link" href="{{route('editsurvey', $currSurvey->id)}}" data-toggle="tooltip" title="" data-original-title="Participation Rate">
						{{-- @if(!empty($currSurvey->max_invitations)) --}}
							<img src="{{ asset('images/icon-3.svg') }}" class="icon" alt="icon" width="18" height="25">
						{{-- @endif --}}
						<span>
							
								@if(!empty($currSurvey->max_invitations))
									
									{{ number_format((100 * $currSurvey->total_responded) / $currSurvey->max_invitations,2) }}
								
								@else 
									{{ 'N/A' }} 
								@endif
							
							
						</span>
					</a>
				</li>
				<li>
					<a class="link" href="{{route('editsurvey', $currSurvey->id)}}" data-toggle="tooltip" title="" data-original-title="Days Remaining">
						<img src="{{ asset('images/icon-4.svg') }}" class="icon" alt="icon" width="19" height="25">
						<span>{{ $currSurvey->remaining_days }}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
@empty
<div class="no-data">
	<div class="text-center">
		<img src="{{ asset('images/no-data.png') }}" alt="no-data" height="80px;"/>
		<h4>Sorry we couldn't find any matches</h4>
		<p>Maybe your search was too specific, please try searching with another term </p>
	</div>
</div>
@endforelse