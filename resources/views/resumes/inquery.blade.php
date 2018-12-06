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
        #m_nav .menu li.active a{
            color:#2f6358;
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
                            <li class="active"><a href="{{ route('resumes.inquery') }}" title="履歷查询">履歷查询</a> </li>
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
                    <h1><span>履歷查詢</span></h1>
                </div>
                <div class="con">
                    <form action="{{ route('resumes.search') }}" method="post">
                        @csrf
                        <div class="form_group">
                            <label for="select_teaField">茶園場域</label>
                            <select class="form-control" id="select_teaField" name="location">
                                <option value=''>請選擇</option>
                                @foreach($locations as $key=>$val)
                                <option value="{{ $key }}">{{ str_replace('"', '', $val) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form_group">
                            <label for="select_cropNum">作物批號</label>
                            <select class="form-control" id="select_cropNum" name="crop">
                                <option value=''>請選擇</option>
                                @foreach($crops as $key=>$val)
                                <option value="{{ $key }}">{{ str_replace('"', '', $val) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form_btn">
                            <div class="submit_btn">
                                <button type="submit" class="btn">查詢</button>
                            </div>
                            <div class="reset_btn">
                                <button type="reset" class="btn ">清除</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <!--下版-->
    <footer id="footer">
        <div class="inner">
            <p>國立台灣大學生物環境系統工程學研究所生物資源暨農學院</p>
            <p>106 台北市大安區羅斯福路四段1號 台大浩瀚樓6樓603室</p>
            <p>+886-2-3366-3488</p>
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
            $('.reset_btn').click(function(e){
                e.preventDefault();
                $("#select_teaField").val($("#select_teaField option:first").val());
                $("#select_cropNum").val($("#select_cropNum option:first").val());
            })
        });

    </script>
</body>

</html>
