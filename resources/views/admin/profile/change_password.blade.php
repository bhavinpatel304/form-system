@extends('layouts.admin')
@section('page_title', 'Change Password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                 @if( Session::has( 'failed' ))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get( 'failed' ) }}
                    </div>
                @endif

                @if( Session::has( 'success' ))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get( 'success' ) }}
                    </div>
                @endif
                <div class="card-header">Change Password</div>

                    <div class="card-body">
                    <form method="POST" action="{{ route('changepassword') }}" novalidate>
                        @csrf

                         <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="password_confirmation" required >

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>

                    </form>

                
            </div>
        </div>
    </div>
</div>
@endsection
