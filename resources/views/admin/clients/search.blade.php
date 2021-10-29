@forelse($clients as $currClients)
<?php
	$cardClass = '';
	if($currClients->status == 2){
		
//			$cardClass = 'disabled-card';
	}
?>
<div class="col-xl-3 col-sm-6 col-xs-12 P-10 ">
	<div class="card survey-card <?= $cardClass; ?>">
		<div class="card-body text-center ">
			<div class="company-logo">
				
				<a href="javascript:void(0)" class="showEditModal" data-target-id="{{ $currClients->id }}">
					
					@if (empty($currClients->company_logo) || !file_exists($company_thumb_path . $currClients->company_logo))
					
					<img src="{{ url('/images/' . env('DEFAULT_COMPANY_IMAGE','')) }}" id="liveimage" alt="company_logo"  data-toggle="tooltip" title="{{ $currClients->company_name }}" data-placement="bottom" />
					@else
					<?php  $imageUrl = url($imgUrl) . '/' . $currClients->company_logo; ?>
					<img src="<?= url($imageUrl); ?>" id="liveimage" alt="company_logo"  data-toggle="tooltip" title="{{ $currClients->company_name }}" data-placement="bottom" />
					@endif
					
				</a>
			</div>
			{{-- <div class="ml-auto closebtn">
				<a href="javascript:void(0)" data-id="{{ $currClients->id }}" class="removeMe close ">
					<span aria-hidden="true">&times;</span>
				</a>
			</div> --}}
			@php
				$newStatus = 2;
				$dataOriginalTitle = 'Active Client';
				$toggleStatusClass = 'fa fa-toggle-on';
			@endphp
			@if($currClients->status == 2)
				@php
					$newStatus = 1;
					$dataOriginalTitle = 'Inactive Client';
					$toggleStatusClass = 'fa fa-toggle-off';
				@endphp
			@endif
			<div class="ml-auto inactiveActiveLinkDiv">
				<a  href="javascript:void(0)" data-status="<?= $newStatus; ?>" data-id="{{ $currClients->id }}" class="inactiveActiveLink" data-toggle="tooltip" title="" data-original-title="<?= $dataOriginalTitle ; ?>">
					{{-- <i class="fa fa-download" aria-hidden="true"></i> --}}
					<i class="<?= $toggleStatusClass; ?>"></i>
				</a>
			</div>
			
		</div>
		<div class="card-fotter">
			<ul class="bottom-icon">
				<li class="invited">
					<a class="link showEditModal"   data-target-id="{{ $currClients->id }}" href="javascript:void()" data-toggle="tooltip" title="Total Survey">
						<img src="{{ asset('images/icon-5.svg') }}" width="18" height="25" class="icon"
						alt="icon" />
						<span>{{ $currClients->total_survey }}</span>
					</a>
				</li>
				<li>
					<a class="link showEditModal" data-target-id="{{ $currClients->id }}" href="javascript:void()" data-toggle="tooltip" title="Invited">
						<img src="{{ asset('images/icon-1.svg') }}" width="16" height="25" class="icon"
						alt="icon" />
						<span>{{ $currClients->total_invitation }}</span>
					</a>
				</li>
				<li>
					<a class="link showEditModal" data-target-id="{{ $currClients->id }}" href="javascript:void()" data-toggle="tooltip" title="Responded">
						<img src="{{ asset('images/icon-2.svg') }}" width="18" height="25" class="icon"
						alt="icon" />
						<span>
							@if (isset($arrResponse[$currClients->id]))
								@php
									$intResponse = $arrResponse[$currClients->id];
								@endphp
							@else
								@php
									$intResponse = 0;
								@endphp
							@endif
							{{ $intResponse }}
						</span>
					</a>
				</li>
				<li>
					<a class="link showEditModal" data-target-id="{{ $currClients->id }}" href="javascript:void()" data-toggle="tooltip" title="Participation Rate">
						<img src="{{ asset('images/icon-3.svg') }}" width="18" height="25" class="icon"
						alt="icon" />
						<span>
							@if ($currClients->total_invitation>0)
							{{ number_format((100 * $intResponse) / $currClients->total_invitation, 2) }}
							@else
							0
							@endif
						</span>
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