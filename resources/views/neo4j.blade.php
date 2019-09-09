<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>{{ trans('custom.page_title') }}</title>
    <!--Web default meta-->
    <meta name="robots" content="index, follow">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="{{ trans('custom.page_title') }}">
    <!--Web css-->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/animate_min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .img-container {
            width: 90%;
            margin: auto;
            text-align: center;
        }

        .img-container a {
            background: #fbb03b;
            border: none;
            font-family: "微軟正黑體";
            color: #333;
            font-size: 16px;
            letter-spacing: 5px;
            border-radius: 50px;
            padding: 10px 60px;
            cursor: pointer;
        }

        .img-container a:hover {
            color: #ffffff;
        }
    </style>
</head>

<body id="page" class="resumeInq">
    <div id="navbar_top"> <a id="rwd_nav" href="#m_nav">
            <div class="ico"><span></span></div>
        </a> </div>
    <!--上版-->
    <header id="header">
        <div class="inner">
            <div id="header_logo">
                <a href="{{route('homes.index')}}">
                    <img src="{{ asset("images/logo_".app()->getLocale().".svg") }}"
                        alt="{{ trans('custom.page_title') }}">
                </a>
            </div>
            <nav id="header_nav">
                <div id="m_nav">
                    <div id="menu">
                        <ul class="menu">
                            <li>
                                <a href="{{ route('homes.index','#about') }}"
                                    title="{{ trans('custom.traceabilty_about') }}" data-scroll="#about">
                                    {{ trans('custom.traceabilty_about') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('homes.index','#core') }}"
                                    title="{{ trans('custom.blockchain_about') }}" data-scroll="#core">
                                    {{ trans('custom.blockchain_about') }}
                                </a>
                            </li>
                            <li><a href="{{ route('resumes.inquiry') }}"
                                    title="{{ trans('custom.resume_search') }}">{{ trans('custom.resume_search') }}</a>
                            </li>
                            <li><a href="{{ route('resumes.index') }}"
                                    title="{{ trans('custom.resume_latest') }}">{{ trans('custom.resume_latest') }}</a>
                            </li>
                            <li class="active">
                                <a href="{{ route('neo4j.view','441748') }}" title="neo4j">
                                    Neo4j
                                </a>
                            </li>
                        </ul>
                        <label class="switch">
                            <input type="checkbox" id="togBtn" {{ session('locale')=='en'?'checked':'' }}>
                            <div class="slider round"></div>
                        </label>
                    </div>
                    <a href="javascript:$.pageslide.close()" class="bars_close"></a>
                </div>
            </nav>
        </div>
    </header>
    <main id="main">
        <div class="inner">
            <section id="rsu_inquire">
                <div class="tit {{ session('locale') }}">
                    <h1><span>Neo4j</span></h1>
                </div>
            </section>
        </div>
        <div class="img-container">
            @if($next)
            <a href="{{ route('neo4j.view', $next)}}">
            <img src="{{ asset("images/$image.jpg")}}" alt="">
            </a>
            @else 
            <img src="{{ asset("images/$image.jpg")}}" alt="">
            @endif
            
        </div>
    </main>
    <!--下版-->
    <footer id="footer">
        <div class="inner">
            <p>{{ trans('custom.sponsor') }}</p>
            <p>{{ trans('custom.maintain') }}</p>
            <p>{{ trans('custom.location') }}</p>
            <p>{{ trans('custom.service_line') }}：+886-2-33663468</p>
        </div>
    </footer>
    <!--Web jquery-->
    <script src="{{ asset('js/jquery-1.11.3.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery_pageslide_min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#rwd_nav").pageslide({
                modal: true
            });
            $('.reset_btn').click(function (e) {
                e.preventDefault();
                $errMsg.hide();
                $select_farmField.val(null).change();
            })

            var $select_farmField = $('#select_farmField');
            var $product_group = $('#product_group');
            var $select_productField = $('#select_productField');
            var $submit_btn = $('.submit_btn .btn');
            var $errMsg = $('#errMsg');
            var $search_form = $('#search_form');

            $submit_btn.click(function(e){
                $errMsg.hide();
                $submit_btn.prop('disabled', 'disabled');
                $search_form.submit();
            });

            $select_farmField.val('').change();

            $select_farmField.change(function () {
                $errMsg.hide();
                var value = $(this).val();
                $product_group.hide();
                $select_productField.html("").prop('disabled', 'disabled');
                if (value) {
                    $select_farmField.prop('disabled', 'disabled');
                    $submit_btn.prop('disabled', 'disabled');
                    var $ajaxError = function(r, textStatus, err){
                        var e = JSON.parse(r.responseText);
                        $errMsg.show().find('p').text(JSON.stringify(e.errors));
                    };

                    $.ajax({
                        url: "{{ route('resumes.product') }}",
                        type: 'GET',
                        data: {farm: value},
                        success: function (response, textStatus, jqXhr) {
                            if(response.length == 0){
                                return $ajaxError({"responseText":"{\"errors\":\"{{__('custom.empty_product')}}\"}"}, textStatus, null);
                            }
                            for(var key in response) {
                                $select_productField.append("<option value="+ encodeURI(key) + ">" + key + "</option>")
                            }
                            $select_productField.prop('disabled', false);
                            $product_group.show();
                            // console.log(response);
                        },
                        error: $ajaxError,
                        complete: function () {
                            $select_farmField.prop('disabled', false);
                            $submit_btn.prop('disabled', false);
                        }
                    });
                } else {
                    
                }
            });
        });

    </script>
</body>

</html>