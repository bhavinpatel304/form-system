@extends('layouts.error')

@section('content')
<div class="d-flex justify-content-center h-p100 page-error bg-primary">
    <div class="align-self-center">
        <h1 class="animation-slide-top">
            500
        </h1>
        <p>
            Server side err
            <img src="{{ asset('assets/images/sad.png') }}" style="height: 26px; margin: 0px 3px;"/>
            r
        </p>
        <p class="error-advise">
            YOU SEEM TO BE TRYING TO FIND HIS WAY HOME
        </p>
        <a class="btn btn-s-sm btn-white waves-effect waves-classic btn-round" href="{{ url('/') }}">
            GO TO HOME PAGE
        </a>
    </div>
</div>
@endsection
