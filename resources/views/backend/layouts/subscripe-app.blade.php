@include('backend.partials.header')
@include('backend.partials.navbar')
@include('backend.partials.subHeader')

<!-- begin:: Content -->
<div class="row kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content" style="margin: 15% 0px 15% 0px; ">

    @yield('content')

</div>
<!-- end:: Content -->


@include('backend.partials.footer')
