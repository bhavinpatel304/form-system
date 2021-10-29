@extends('layouts.auth')
@section('page_title', 'Activate')
@section('content')
<div class=" page loginScreen">
   <div class="d-flex justify-content-center h-p100">
      <div class="align-self-center wow fadeIn" data-wow-duration="4s">
         <div class="login-text text-center">
            <h2>Welcome To</h2>
            <h6>Admin Panel</h6>
         </div>
         <div class="card login-form text-center ">
            <div class="card-body">
               <div class="brand-logo">
                  <img src="{{ asset('images/logo.png') }}" alt="logo">
               </div>
               <h2 class="small-text">Activate </h2>     

               <div class="col-md-12 col-lg-12 login-form-padder">
                    <div class=" d-flex justify-content-left login-form h-p100">
                        <div class="align-self-center w-p100 ">
                            {{-- <div class="text-center mb-5">
                                <img src="{{ url('assets/images/logo.svg') }}" width="75%"/>
                            </div> --}}


                            <div class="text-center">
                                @if (empty($arrUser))
                                <p class="badge badge-danger">
                                    Invalid Token
                                </p>
                                @elseif ($arrUser->status==1)
                                <p class="badge badge-warning">
                                    Your account is already activated.
                                </p>
                                @elseif ($arrUser->status==3)
                                <p class="badge badge-danger">
                                    Your account is in archived.
                                </p>
                                @else
                                <p class="badge badge-success">
                                    Your account is activated successfully
                                </p>
                                @endif
                                <p>
                                    <a class="align-self-center text-primary textLink" href="{{ route('login') }}">
                                        Login
                                    </a>
                                </p>
                            </div>
                        </div>
                       
                    </div>
                </div>         
               
               
            </div>
         </div>
      </div>
   </div>
   @include('admin.common.footer')
</div>
@endsection

@section('scripts')
 @parent
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
@endsection


@section('jscode')
<script>
  $.validate({
      validateOnBlur : true,
    
  });
  @include('admin.common.login_js')
</script>
@endsection

