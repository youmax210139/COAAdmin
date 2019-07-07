@inject('request', 'Illuminate\Http\Request')
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
    <link href="{{ asset('calendar/zabuto_calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .no_results{
            text-align: center;
            font-weight: 800;
            font-size: 28px;
            color: red;
        }
        .info_box .more a:nth-child(2){
            margin-left: 10%;
        }
        .info_box .more a,
        .vfc_txt .more a{
            color: #2F6156;
            font-weight: 600;
        }
        .info_box .more a:visited,
        .vfc_txt .more a:visited{
            color: #990088;
        }
        #verification .vfc_btn a{
            color: white;
        }
    </style>
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
                            <li><a href="{{ route('homes.index','#about') }}" title="什麼是產銷履歷">什麼是產銷履歷</a> </li>
                            <li><a href="{{ route('homes.index','#core') }}" title="什麼是區塊鏈">什麼是區塊鏈</a> </li>
                            <li><a href="{{ route('homes.index','#banner') }}" title="如何加入產銷履歷">如何加入產銷履歷</a> </li>
                            <li><a href="{{ route('resumes.inquiry') }}" title="履歷查詢">履歷查詢</a> </li>
                            <li class="{{ empty($request->query())?'active':'' }}">
                                <a href="{{ route('resumes.index') }}" title="最新履歷">最新履歷</a>
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
    <div id="banner">
        <img src="{{ asset('images/page_banner.svg') }}">
        <span class="txt">{{ empty($request->query())?'最新履歷':'履歷資訊' }}</span>
    </div>
    <main id="main">
        <div class="inner">
            @if($logs->isEmpty())
            <p class="no_results">查詢無結果</p>
            @else
                @if(!empty($request->query()) && count($products) == 1 && $product= $products[0])
                <section id="rsu_info">
                    <div class="info_box">
                        <p class="harvesting"><span>作物批號</span><em>{{ $product->product_name??'--' }}</em></p>
                        <p class="farm"><span>農場</span><em>{{ $product->farm??'--' }}</em></p>
                        <p class="city"><span>城市</span><em>{{ $product->city??'--' }}</em></p>
                        <p class="Township"><span>城鎮</span><em>{{ $product->town??'--' }}</em></p>
                        <p class="address"><span>地址</span><em>{{ $product->address??'--' }}</em></p>
                        <p class="tel"><span>電話</span><em>{{ $product->tel??'--' }}</em></p>
                        <p class="more"><span></span><em>
                                <a href="{{$product->more_info_url??'/'}}" target="_blank">更多資訊</a>
                                <a href="{{$product->bc_address??'/'}}" target="_blank">區塊鏈智能合約</a>
                            </em>
                        </p>
                    </div>
                </section>
                @endif
            <section id="search">
                <div id="calendar"></div>
            </section>
            <section id="verification">
                @foreach($logs as $key => $l)
                <div class="vfc_box" data-scroll="{{ $l->scrollId }}">
                    <div class="date">{{ $l->date }}</div>
                    <a href="{{$l->bc_explore_url??'/'}}" target="_blank" class="vfc_btn_wrapper">
                        <div class="vfc_btn" id="v_{{ $l->log_id }}">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            <div class="text" style="display:none"></div>
                        </div>
                    </a>
                    <div class="vfc_txt">
                        <p class="project">作業項目:{{ $l->task??'--' }}</p>
                        <p class="operators">作業場域:{{ $l->location??'--' }}</p>
                        <p class="tool">{{$l->tool_type??'--'}}:{{ $l->tool??'--' }}</p>
                        <p class="explain">備註:{{ $l->remark??'--' }}</p>
                        <p class="more"><a href="{{$l->product->more_info_url??'/'}}" target="_blank">更多資訊</a></p>
                    </div>
                </div>
                @endforeach
            </section>
            @endif
            <div class="back_btn"><a href="{{ route('resumes.inquiry') }}">返回</a></div>
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
    <script src="{{ asset('calendar/zabuto_calendar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script>
        var $calendar = null;
        $(document).ready(function () {
            $("#rwd_nav").pageslide({
                modal: true
            });
            @if(!$logs->isEmpty())
            $calendar = $("#calendar").zabuto_calendar({
                language: "en",
                data: @json($dates),
                today: false,
                show_days: true,
                year: "{{ $year??null }}",
                month: "{{ $month??null }}",
                weekstartson: 1,
                cell_border: true,
                nav_icon: {
                    prev: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                },
                action: function () {
                    return onDateSelected(this.id, false);
                },
            });
            $("#"+$calendar.attr('id')+"_{{ $dates[0]['date'] }}").click();
            $.ajax({
                url: "{{ route('resumes.validation') }}",
                type: 'GET',
                data: { 'products[]':{!! $products->pluck('product_id') !!} },
                success: function (response, textStatus, jqXhr) {
                    $( ".vfc_btn" ).each(function( index ) {
                        $(this).find(".lds-ring").hide();
                        if(response[$(this).attr('id').substr(2)]){
                            $(this).removeClass("ok no").addClass("ok");
                            $(this).find(".text").text("已驗証").show();
                        }
                        else{
                            $(this).removeClass("ok no").addClass("no");
                            $(this).find(".text").text("未驗証").show();
                        }
                    });
                },
                error: function(r, textStatus, err){
                    console.error(r.responseJSON.message);
                },
                complete: function () {
                }
            });
            @endif
        });

        function onDateSelected(id, fromModal) {
            $(".zabuto_calendar .table td.active").removeClass('active');
            $("#" + id).addClass('active');
            var date = $("#" + id).data("date");
            var hasEvent = $("#" + id).data("hasEvent");
            if (hasEvent) {
                $('#verification').scrollTo('[data-scroll='+date+']:first', 1000, 'swing');
            }
        }

    </script>
</body>

</html>
