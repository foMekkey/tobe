<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('site.site_name') }}</title>
        <link href="{{ asset('site_assets') }}/css/bootstrap.min.css" rel="stylesheet">
        @if(app()->getLocale() == 'ar')
          <link href="{{ asset('site_assets') }}/css/bootstrap-rtl.min.css" rel="stylesheet">
        @endif
        <link href="{{ asset('site_assets') }}/css/main.css" rel="stylesheet">
        <link href="{{ asset('site_assets') }}/css/responsive.css" rel="stylesheet">
        @if(app()->getLocale() == 'ar')
          <link href="{{ asset('site_assets') }}/css/ar.css" rel="stylesheet">
        @endif
        <link href="{{ asset('site_assets') }}/css/animate.css" rel="stylesheet">
        <link href="{{ asset('site_assets') }}/fonts/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
        <link href="{{ asset('site_assets') }}/fonts/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
        <link href="{{ asset('site_assets') }}/css/owl.carousel.css" rel="stylesheet">
        <link href="{{ asset('site_assets') }}/images/logo.png" rel="shortcut icon">
        
        <link href="{{ asset('site_assets') }}/css/custom.css" rel="stylesheet">
        
        @yield('styles')
    </head>
    <body>
        <section class="top">
            <div class="container-fluid">
                <div class="row">
                    <div class="left">
                        <img src="{{ asset('site_assets') }}/images/advice_logo.png">
                        <p>{{ __('site.site_intro') }}</p>
                    </div>
                    <div class="right">
                        <ul class="list-inline social_icons">
                            <li><a href="{{ $settings['linkedin_link'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="{{ $settings['instagram_link'] }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{ $settings['youtube_link'] }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="{{ $settings['twitter_link'] }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="{{ $settings['facebook_link'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- top -->
        <section class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="navigation">
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-xs-8">
                                <a href="{{ url('site') }}" class="logo"><img src="{{ asset('site_assets') }}/images/logo.png"></a>
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-4">
                                <i class="fa fa-bars clicker fa-2x" onclick="openNav()"></i>


                                <nav class="navbar navbar-default overlay" id="myNav">
                                    <a href="javascript:void(0)" class="closebtn hidden-lg hidden-md" onclick="closeNav()">&times;</a>

                                    <h1 class="logo2 hidden-lg hidden-md"><img src="{{ asset('site_assets') }}/images/advice_logo.png"></h1>

                                    <ul class="list-inline nav-right">
                                        <li>
                                            @if(Auth::check())
                                            <a href="{{route('logout')}}" class="btn black_hover">{{ __('site.logout') }}</a>
                                            @else
                                                <a href="{{route('register')}}" class="btn black_hover">{{ __('site.sign_up') }}</a>
                                                <a href="{{route('login')}}" class="btn black_hover">{{ __('site.login') }}</a>
                                            @endif
                                        </li>
                                        <li class="search">
                                            <a href="#" class="search_btn"><i class="fas fa-search"></i></a>
                                            <div class="search_sec">
                                                <form method="get" action="{{ url('site/courses') }}">
                                                    <div class="form-group">
                                                        <input name="keyword" type="text" class="form-control" placeholder="{{ __('site.search') }}...">
                                                    </div>
                                                </form>
                                                <a href="#" class="close_search"><span class="fa fa-times close_search"></span></a>
                                            </div>
                                        </li>
                                        <li class="lang"><a href="{{ url('site/switch_language/' . (app()->getLocale() == 'en' ? 'ar' : 'en')) }}"><i class="fas fa-globe-americas"></i>{{ __('site.other_lang') }}</a></li>
                                    </ul>

                                    <ul class="nav navbar-nav overlay-content">
                                        <li><a href="{{ url('site') }}">{{ __('site.home') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a></li>
                                        <li class="menu-item-has-children">
                                            <a href="#">{{ __('site.know') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a>
                                            <span class="fa fa-caret-down"></span>

                                            <ul class="sub-menu">
                                                @foreach ($settings['know_pages'] as $pageLink)
                                                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                @endforeach
                                            </ul>							
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">{{ __('site.discover') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a>
                                            <span class="fa fa-caret-down"></span>

                                            <ul class="sub-menu">
                                                <li class="menu-item-has-children">
                                                    <a href="#">{{ __('site.individuals_services') }}</a>
                                                    <span class="fa fa-caret-{{ __('site.right') }}"></span>
                                                    <ul class="sub-menu2">
                                                        @foreach ($settings['individuals_services'] as $pageLink)
                                                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">{{ __('site.companies_services') }}</a>
                                                    <span class="fa fa-caret-{{ __('site.right') }}"></span>
                                                    <ul class="sub-menu2">
                                                        @foreach ($settings['companies_services'] as $pageLink)
                                                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @foreach ($settings['discover_pages'] as $pageLink)
                                                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                @endforeach
                                            </ul>							
                                        </li>
                                        <li><a href="{{ url('site/blog') }}">{{ __('site.blog') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a></li>
                                        <li><a href="{{ url('site/courses') }}">{{ __('site.courses') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a></li>
                                        <li><a href="{{ url('site/contact') }}">{{ __('site.contact') }}<img src="{{ asset('site_assets') }}/images/advice_logo.png"></a></li>
                                    </ul>


                                </nav>
                                <div id="body-overlay"></div>
                                <div id="body-overlay2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end-header -->
        
        @yield('content')
        
        <!-- article -->
        <div class="container-fluid">
            <div class="Subscribe wow zoomIn">
                <div>
                    <h1>{{ __('site.newsletter_title') }}</h1>
                    <h3>{{ __('site.newsletter_intro') }}</h3>
                </div>
                <form id="add_newsletter_form">
                    <input type="email" class="form-control" name="email" placeholder="{{ __('site.your_email_address') }}">
                    <div id="add_newsletter-alert" class="alert alert-success" role="alert" style="display: none"></div>
                    @csrf
                    <input type="submit" class="btn black_hover" value="{{ __('site.subscribe_us') }}" id="add_newsletter">
                </form>
            </div>
        </div><!-- Subscribe -->

        <footer>
            <div class="top_footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <img src="{{ asset('site_assets') }}/images/advice_logo.png" class="footer_logo">
                            <p>{{ $settings['footer_info_' . app()->getLocale()] }}</p>
                            <ul class="info_list">
                                <li><i class="fas fa-phone-alt"></i>{{ $settings['contact_number'] }}</li>
                                <li><i class="fas fa-envelope"></i>{{ $settings['email'] }}</li>
                                <li><i class="fas fa-map-marker-alt"></i>{{ $settings['address_' . app()->getLocale()] }}</li>
                            </ul>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="middle">
                                <div class="links">
                                    <h3 class="footer_title">{{ __('site.navigation') }}</h3>
                                    <ul>
                                        <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                                        <li><a href="{{ url('site/know') }}">{{ __('site.know') }}</a></li>
                                        <li><a href="{{ url('site/discover') }}">{{ __('site.discover') }}</a></li>
                                        {{-- <li><a href="{{ url('site/about') }}">{{ __('site.know') }}</a></li>
                                        <li>
                                            <a href="#">{{ __('site.know') }}</a>
                                            <ul>
                                                @foreach ($settings['know_pages'] as $pageLink)
                                                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                @endforeach
                                            </ul>							
                                        </li>
                                        <li>
                                            <a href="#">{{ __('site.discover') }}</a>
                                            <ul>
                                                <li>
                                                    <a href="#">{{ __('site.individuals_services') }}</a>
                                                    <ul>
                                                        @foreach ($settings['individuals_services'] as $pageLink)
                                                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">{{ __('site.companies_services') }}</a>
                                                    <ul>
                                                        @foreach ($settings['companies_services'] as $pageLink)
                                                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @foreach ($settings['discover_pages'] as $pageLink)
                                                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                                                @endforeach
                                            </ul>							
                                        </li> --}}
                                        <li><a href="{{ url('site/blog') }}">{{ __('site.blog') }}</a></li>
                                        <li><a href="{{ url('site/courses') }}">{{ __('site.courses') }}</a></li>
                                        <li><a href="{{ url('site/contact') }}">{{ __('site.contact') }}</a></li>
                                    </ul>
                                </div>
                                <div class="links">
                                    <h3 class="footer_title">{{ __('site.support') }}</h3>
                                    <ul>
                                        {{-- <li><a href="#">{{ __('site.faq') }}</a></li> --}}
                                        <li><a href="{{ url('site/page/privacy_policy') }}">{{ __('site.privacy_policy') }}</a></li>
                                        {{-- <li><a href="#">{{ __('site.support') }}</a></li>
                                        <li><a href="#">{{ __('site.documentation') }}</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <h3 class="footer_title">{{ __('site.latest_news') }}</h3>
                            @if(count($settings['blog']))
                                @foreach ($settings['blog'] as $settingBlog)
                                <div class="news_block">
                                    <a href="{{ url('site/blog/' . $settingBlog->id) }}">
                                        <img src="{{ asset("uploads/".$settingBlog->image) }}">
                                        <div>
                                            <h4>{{ $settingBlog->title }}</h4>
                                            <p>{{ \Carbon\Carbon::parse($settingBlog->date)->format('M j, Y') }}</p>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div><!-- row -->
                </div>
            </div>

            <div class="bottom">
                <div class="container-fluid">
                    <div class="row">
                        <div class="bottom_content">
                            <p>
                                {{ __('site.development_by') }}
                                <a href="#"><img src="{{ asset('site_assets') }}/images/tqniaen-logo.png"></a>
                                . {{ __('site.all_right_reserved') }}.
                            </p>
                            <ul class="list-inline social_icons">
                                <li><a href="{{ $settings['linkedin_link'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="{{ $settings['instagram_link'] }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="{{ $settings['youtube_link'] }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="{{ $settings['twitter_link'] }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="{{ $settings['facebook_link'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('site_assets') }}/js/jquery-3.2.0.js"></script>
        <script src="{{ asset('site_assets') }}/js/bootstrap.min.js"></script>
        <script src="{{ asset('site_assets') }}/js/owl.carousel.min.js"></script>
        <script src="{{ asset('site_assets') }}/js/wow.min.js"></script>
        <script src="{{ asset('site_assets') }}/js/animate-number.js"></script>
        <script src="{{ asset('site_assets') }}/js/script.js"></script>
        <script src="{{ asset('site_assets') }}/js/jquery.validate.min.js"></script>
        <script>
            @if(app()->getLocale() == 'ar')
                $.extend($.validator.messages, {
                    '*'        : 'هذا الحقل مطلوب',
                    'email'    : 'يرجى ادخال البريد الإلكتروني بشكل صحيح',
                    'required' : 'هذا الحقل مطلوب',
                    'minlength': 'يرجى ادخال على الأقل {0} أحرف',
                    'equalTo'  : "{{ __('site.confirm_pass_not_match') }}",
                });
            @endif
            
            // Typerwrite text content. Use a pipe to indicate the start of the second line "|".  
            var textArray = [
                "better", "happy", "charismatic", "star", "speaker", "brand"
            ];
            
            $('#add_newsletter_form').validate({rules: {
                email: {required: true, email: true}
            }});

            $("#add_newsletter_form").submit(function (event) {
                // Stop form from submitting normally
                event.preventDefault();

                if(!$(this).valid()) return false;

                $('#add_newsletter').prop("disabled", true);

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ url('site/newsletter') }}",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            $('#add_newsletter-alert').removeClass('alert-danger');
                            $('#add_newsletter-alert').addClass('alert-success');
                            $('#add_newsletter-alert').text("{{ __('site.add_newsletter_success') }}");
                            $('#add_newsletter-alert').show();
                            $('#add_newsletter_form').trigger("reset");
                        } else {
                            $('#add_newsletter-alert').removeClass('alert-success');
                            $('#add_newsletter-alert').addClass('alert-danger');
                            $('#add_newsletter-alert').text("{{ __('site.add_newsletter_error') }}");
                            $('#add_newsletter-alert').show();
                        }

                        $('#add_newsletter').prop("disabled", false);
                        
                        setTimeout(function() {
                            $("#add_newsletter-alert").alert('close');
                        }, 10000);
                    }
                });
            });
        </script>
        
        @yield('scripts')
    </body>
</html>