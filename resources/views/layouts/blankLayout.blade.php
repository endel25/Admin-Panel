@extends('layouts/commonMaster' )

@section('layoutContent')

<script src="{{asset('assets/js/main.js')}}"></script>

  @yield('vendor-script')
  <!-- END: Theme JS-->
  @yield('page-script')
  @stack('scripts')
<!-- Content -->
@yield('content')
<!--/ Content -->

@endsection
