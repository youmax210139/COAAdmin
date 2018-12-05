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
</head>

<body id="page" class="resumeInfo">
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
                            <li><a href="/" title="什麼是產銷履歷">什麼是產銷履歷</a> </li>
                            <li><a href="/" title="什麼是區塊鏈">什麼是區塊鏈</a> </li>
                            <li><a href="/" title="如何加入產銷履歷">如何加入產銷履歷</a> </li>
                            <li><a href="{{ route('resumes.inquery') }}" title="履歷查询">履歷查询</a> </li>
                            <li><a href="{{ route('resumes.index') }}" title="最新履歷">最新履歷</a></li>
                        </ul>
                    </div>
                    <a href="javascript:$.pageslide.close()" class="bars_close"></a>
                </div>
            </nav>
        </div>
    </header>
    <div id="banner">
        <img src="{{ asset('images/page_banner.svg') }}">
        <span class="txt">履歷資訊</span>
    </div>
    <main id="main">
        <div class="inner">
            <!--
            <section id="rsu_info">
                <div class="info_box">
                    <p class="pro_name"><span>產品名稱</span><em>茶葉-奇萊58冷香(奇萊58冷香)</em></p>
                    <p class="operator"><span>農產品經營業者</span><em>順美茶廠</em></p>
                    <p class="abbr"><span>簡稱</span><em>順美茶廠</em></p>
                    <p class="user_name"><span>生產者姓名</span><em>許瑞麟</em></p>
                    <p class="place"><span>產地</span><em>南投縣仁愛鄉蘆山段</em></p>
                    <p class="date"><span>日期</span><em>2018-01-09</em></p>
                    <p class="time"><span>時間</span><em>07:33am</em></p>
                    <p class="materials"><span>資材(工具)</span><em>不明</em></p>
                    <p class="quantity"><span>數量</span><em>500斤</em></p>
                </div>
            </section>
            -->
            <section id="search">
                <div class="search_box">
                    <form action="" method="get" autocomplete="off">
                        <input id="dateStar" name="dateStar" type="text" placeholder="請選擇開始日期" class="dateStyle">
                        ~
                        <input id="dateEnd" name="dateEnd" type="text" placeholder="請選擇結束日期" class="dateStyle">
                        <button type="submit" class="ico_enter"><span class="blind">搜尋</span></button>
                    </form>
                </div>
            </section>
            <section id="verification">
                @forelse($lists as $l)
                <div class="vfc_box">
                    {{-- <div class="close"><span>×</span></div> --}}
                    <div class="date">{{ $l->date }}</div>
                    <div class="vfc_btn no">未驗證</div>
                    <div class="vfc_txt">
                        <p class="project">作業日期:{{ $l->date }}</p>
                        <p class="project">作業項目:{{ $l->task }}</p>
                        <p class="operators">作業人員:採後處理場所:{{ $l->operator }}</p>
                        <p class="tool">工具:{{ $l->tool }}</p>
                        <p class="yield">收穫量:{{ $l->haversting }}</p>
                        <p class="yield">茶種:{{ $l->tea_id }}</p>
                        <p class="yield">說明:{{ $l->explain }}</p>
                    </div>
                </div>
                @empty
                    <p>查詢後無結果</p>
                @endforelse
            </section>
            <div class="back_btn"><a href="{{ route('resumes.inquery') }}">返回</a></div>
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
        });

    </script>
</body>

</html>
