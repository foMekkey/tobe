@extends('backend.layouts.app')
@section('style')
    <style>
        .kt-widget5 .kt-widget5__item .kt-widget5__content:last-child
        {
            justify-content: right;
            text-align: right;
        }

        .kt-widget5__item
        {
            margin-bottom: -15px !important
        }

        .check
        {
            line-height: 1px
        }


        .tree, .tree ul {
            margin:0;
            padding:0;
            list-style:none;
            width: 100%;
        }
        .tree ul {
            margin-right:3em;
            position:relative
        }
        .tree ul ul {
            margin-right:.5em
        }
        .tree ul:before {
            content:"";
            display:block;
            width:0;
            position:absolute;
            top:0;
            bottom:0;
            right:0;
            border-right:1px solid
        }
        .tree li {
            margin:0;
            padding:0 1em;
            line-height:2em;
            color:#369;
            font-weight:700;
            position:relative;
        }
        .tree ul li:before {
            content:"";
            display:block;
            width:10px;
            height:0;
            border-top:1px solid;
            margin-top:-1px;
            position:absolute;
            top:1em;
            right:0
        }
        .tree ul li:last-child:before {
            background:#fff;
            height:auto;
            top:1em;
            bottom:0
        }
        .indicator {
            margin-right:5px;
        }
        .tree li a {
            text-decoration: none;
            color:#369;
        }
        .tree li button, .tree li button:active, .tree li button:focus {
            text-decoration: none;
            color:#369;
            border:none;
            background:transparent;
            margin:0px 0px 0px 0px;
            padding:0px 0px 0px 0px;
            outline: 0;
        }


        #myUL {
            margin: 0;
            padding: 0;
        }

        .box {
            cursor: pointer;
            -webkit-user-select: none; /* Safari 3.1+ */
            -moz-user-select: none; /* Firefox 2+ */
            -ms-user-select: none; /* IE 10+ */
            user-select: none;
        }

        .box::before {
            content: "\2610";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }

        .check-box::before {
            content: "\2611";
            color: dodgerblue;
        }

        .nested {
            display: none;
        }

        .active {
            display: block;
        }
        .kt-checkbox-single {
            float: right;
            line-height: 16px;
        }
        .kt-checkbox {
            float: right;
        }
        .fa.fa-minus-circle, .fa.fa-folder-plus {
            margin-left: 16px;
            float: right;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')

    <div class="message">

    </div>

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--height-fluid" style="direction: rtl">

        {{-- head --}}
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">
                <ul id="myTab" class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_widget5_tab1_content" role="tab" aria-selected="false">
                            {{ __('pages.permission') }}
                        </a>
                    </li>
                    <li class="nav-item">


                        <a class="nav-link " data-toggle="tab" href="#kt_widget5_tab2_content" role="tab" aria-selected="false">
                            {{ __('pages.add-new-permission') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body --}}
        <div class="kt-portlet__body">
            <div class="tab-content">

                {{-- permissions list --}}
                <div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
                    <table class="table datatable-basic">
                        <thead>
                        <tr>
                            <th>{{ __('pages.name') }}</th>
                            <th>{{ __('pages.created') }}</th>
                            <th>{{ __('pages.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $r)
                            <tr>
                                <td>{{$r->role}}</td>
                                <td>{{$r->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('editpermissionpage',$r->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$r->id}}" data-token="{{ csrf_token() }}" data-route="{{ route('deletepermission', $r->id) }}">

                                        <i class="la la-trash-o"></i>
                                    </a>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- add new permission  --}}
                <div class="tab-pane" id="kt_widget5_tab2_content">
                    <form action="{{route('storepermissions')}}" method="post">
                        {{csrf_field()}}
                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%;">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.permission-name') }}</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="role_name" class="form-control" placeholder="{{ __('pages.permission-name') }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{Permissions3()}}
                        </div>

                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>
                        {{-- ---------------------------- --}}

                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success">{{ __('pages.save') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection


@section('script')
    <script>
        $.fn.extend({
            treed: function (o) {

                var openedClass = 'fa fa-minus-circle';
                var closedClass = 'fa fa-folder-plus';

                if (typeof o != 'undefined'){
                    if (typeof o.openedClass != 'undefined'){
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined'){
                        closedClass = o.closedClass;
                    }
                };

                //initialize each of the top levels
                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this); //li with children ul
                    branch.prepend("<i class='fa fa-" + closedClass + "'></i>");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children('ul').children().toggle();
                        }
                    })
                    branch.children('ul').children().toggle();
                });
                //fire event from the dynamically added icon
                tree.find('.branch .indicator').each(function(){
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                //fire event to open branch if the li contains an anchor instead of text
                tree.find('.branch>a, .branch>i').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                //fire event to open branch if the li contains a button instead of text
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });

        //Initialization of treeviews

        $('#tree1').treed();

        $('#tree2').treed({openedClass:'fa fa-folder-open', closedClass:'fa fa-minus-circle'});

        $('#tree3').treed({openedClass:'fa fa-chevron-right', closedClass:'fa fa-chevron-down'});


        $('.kt-checkbox input').click(function() {
            checked = false;
            if ($(this).is(':checked')) {
                checked = true;
            }

            $(this).parent().parent().find('input:checkbox').each(function () {
                $(this).prop("checked", checked);
            });
        });

        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
@endsection
