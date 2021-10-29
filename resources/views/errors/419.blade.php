@extends('layouts.error')

@section('content')
<div class="d-flex justify-content-center h-p100 page-error bg-primary">
    <div class="align-self-center">
        <h1 class="animation-slide-top">
            419
        </h1>
        <p>
            Sorry, your session has expired
        </p>
        <a class="btn btn-s-sm btn-white waves-effect waves-classic btn-round" href="{{ redirect()->back()->getTargetUrl() }}">
            Back
        </a>
    </div>
</div>
@endsection
