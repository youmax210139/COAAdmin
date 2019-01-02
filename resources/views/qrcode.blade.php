<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>農業產品產銷履歷區塊鏈資訊網</title>
    <!--Web default meta-->
    <meta name="robots" content="index, follow">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="農業產品產銷履歷區塊鏈資訊網">
    <!--Web css-->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/animate_min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .con svg{
            width: 100% !important;
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
                    <img src="{{ asset('images/logo.svg') }}" alt="農業產品產銷履歷區塊鏈資訊網">
                </a>
            </div>
            <nav id="header_nav">
                <div id="m_nav">
                    <div id="menu">
                        <ul class="menu">
                            <li><a href="{{ route('homes.index','#about') }}" title="什麼是產銷履歷">什麼是產銷履歷</a> </li>
                            <li><a href="{{ route('homes.index','#core') }}" title="什麼是區塊鏈">什麼是區塊鏈</a> </li>
                            <li><a href="{{ route('homes.index','#banner') }}" title="如何加入產銷履歷">如何加入產銷履歷</a> </li>
                            <li class="active"><a href="{{ route('resumes.inquiry') }}" title="履歷查詢">履歷查詢</a> </li>
                            <li><a href="{{ route('resumes.index') }}" title="最新履歷">最新履歷</a></li>
                        </ul>
                    </div>
                    <a href="javascript:$.pageslide.close()" class="bars_close"></a>
                </div>
            </nav>
        </div>
    </header>
    <main id="main">
        <div class="inner">
            <section id="rsu_inquire">
                <div class="tit">
                    <h1><span>QRCODE</span></h1>
                </div>
                <div class="con">
                    {!! QrCode::size(400)->generate(url('/resumes/search?harvesting='.urlencode('107冬茶-青心烏龍'))); !!}
                </div>
            </section>
        </div>
    </main>
    <!--下版-->
    <footer id="footer">
        <div class="inner">
            <p>行政院農委會 計畫補助</p>
            <p>國立台灣大學生物環境系統工程學系 維運</p>
            <p>106 台北市大安區羅斯福路四段1號</p>
            <p>服務電話：+886-2-33663468</p>
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
                $select_farmField.val('').change();
            })

            var $select_farmField = $('#select_farmField');
            var $harvesting_group = $('#harvesting_group');
            var $select_harvestingField = $('#select_harvestingField');
            var $submit_btn = $('.submit_btn .btn');

            $select_farmField.val('').change();
            $select_farmField.change(function () {
                var value = $(this).val();
                $harvesting_group.hide();
                $select_harvestingField.html("").prop('disabled', 'disabled');
                if (value) {
                    $select_farmField.prop('disabled', 'disabled');
                    $submit_btn.prop('disabled', 'disabled');
                    $.ajax({
                        url: "{{ route('resumes.harvesting') }}",
                        type: 'GET',
                        data: {
                            farm: value
                        },
                        success: function (response, textStatus, jqXhr) {
                            for (var key in response) {
                                $select_harvestingField.append("<option value=" + key + ">" +
                                    key + "</option>")
                            }
                            $select_harvestingField.prop('disabled', false);
                            $harvesting_group.show();
                            $select_farmField.prop('disabled', false);
                            $submit_btn.prop('disabled', false);
                            // console.log(response);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // console.error(jqXhr.responseJSON.message);
                        },
                        complete: function () {}
                    });
                } else {

                }
            });
        });

    </script>
</body>

</html>
