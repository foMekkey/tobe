@include('backend.partials.header')
@include('backend.partials.navbar')
@include('backend.partials.subHeader')

<!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

    @yield('content')

    </div>
<!-- end:: Content -->


@include('backend.partials.footer')



