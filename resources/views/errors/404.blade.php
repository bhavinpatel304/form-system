@extends('layouts.error')

@section('content')
<div class="d-flex justify-content-center h-p100 page-error bg-primary">
    <div class="align-self-center">
        <h1 class="animation-slide-top">
            404
        </h1>
        <p>
            PAGE NOT F
            <img src="{{ asset('images/sad.png') }}" style="height: 26px; margin: 0px 3px;"/>
            UND !
        </p>
        <p class="error-advise">
            YOU SEEM TO BE TRYING TO FIND HIS WAY HOME
        </p>
       
          @if(Str::contains(request()->path(), 'admin') )
                <a class="btn btn-s-sm btn-white waves-effect waves-classic btn-round" href="{{ url('/admin') }}">
                    GO TO HOME PAGE
                </a>  
          @else
                <a class="btn btn-s-sm btn-white waves-effect waves-classic btn-round" href="{{ url('/') }}">
                    GO TO HOME PAGE
                </a>         
          @endif
     
        
    </div>
</div>
@endsection
