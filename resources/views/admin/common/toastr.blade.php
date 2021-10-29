<script>
     toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "z-index":"99999",
    }
</script>
@if(session('login_failed'))
<script>   
    toastr["error"]("{!!  session('login_failed')  !!}" );
    </script>
@endif

@if(session('login_success'))
<script>   
    toastr["success"]("{!!  session('login_success')  !!}");
</script>
@endif

@if(session('logout_success'))
<script>      
    toastr["success"]("{!!  session('logout_success')  !!}");
</script>
@endif

@if(session('status'))
<script>     
    toastr["success"]("{!!  session('status')  !!}");
</script>
@endif

@if(session('msg_success'))
<script>     
    toastr["success"]("{!!  session('msg_success')  !!}");
</script>
@endif

@if(session('msg_failed'))
<script>     
    toastr["error"]("{!!  session('msg_failed')  !!}");
</script>
@endif


@error('email')
<script>    
    toastr["error"]("Invalid Credentials" );
</script>
@enderror
