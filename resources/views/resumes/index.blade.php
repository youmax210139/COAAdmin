@inject('request', 'Illuminate\Http\Request')
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
    <link href="{{ asset('calendar/zabuto_calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .no_results {
            text-align: center;
            font-weight: 800;
            font-size: 28px;
            color: red;
        }

        .info_box .more a:nth-child(2) {
            margin-left: 10%;
        }

        .info_box .more a,
        .vfc_txt .more a {
            color: #2F6156;
            font-weight: 600;
        }

        .info_box .more a:visited,
        .vfc_txt .more a:visited {
            color: #990088;
        }

        #verification .vfc_btn a {
            color: white;
        }
    </style>
</head>

<body id="page" class="resumeInfo">
    <div id="navbar_top"> <a id="rwd_nav" href="#m_nav">
            <div class="ico"><span></span></div>
        </a> </div>
    <!--上版-->
    @include('partials.header')
    <div id="banner">
        <img src="{{ asset('images/page_banner.svg') }}">
        <span class="txt {{ session('locale')}}">
            {{ empty($request->query())? trans('custom.resume_latest'):trans('custom.resume_info') }}
        </span>
    </div>
    <main id="main">
        <div class="inner">
            <p class="no_results" style="{{ $logs->isEmpty()?'':'display:none' }}">{{ trans('custom.empty_product') }}
            </p>
            @if(!$logs->isEmpty())
            <section id="rsu_info" style="display:none">
                <div class="info_box">
                    <p class="harvesting">
                        <span>{{ trans('custom.crop_code') }}</span>
                        <em></em>
                    </p>
                    <p class="farm">
                        <span>{{ trans('custom.farm') }}</span>
                        <em></em>
                    </p>
                    <p class="city">
                        <span>{{ trans('custom.city') }}</span>
                        <em></em>
                    </p>
                    <p class="Township">
                        <span>{{ trans('custom.town') }}</span>
                        <em></em>
                    </p>
                    <p class="address"><span>
                            {{ trans('custom.address') }}</span>
                        <em></em>
                    </p>
                    <p class="tel">
                        <span>{{ trans('custom.phone') }}</span>
                        <em></em>
                    </p>
                    <p class="more">
                        <span></span>
                        <em></em>
                    </p>
                </div>
            </section>
            <section id="search">
                <div id="calendar"></div>
            </section>
            <section id="verification">
                @foreach($logs as $key => $l)
                <div class="vfc_box" data-scroll="{{ $l->scrollId }}" data-product="{{ $l->product->product_id }}">
                    <div class="date">{{ $l->date }}</div>
                    <a href="{{$l->bc_explorer_url??''}}" target="_blank" class="vfc_btn_wrapper">
                        <div class="vfc_btn" id="v_{{ $l->log_id }}">
                            <div class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <div class="text" style="display:none"></div>
                        </div>
                    </a>
                    <div class="vfc_txt">
                        <p class="crop_code more">
                            <a href="{{ route('resumes.index', [ 'product'=>$l->product_id??'' ])}}" 
                                target="_blank">
                            {{ trans('custom.crop_code') }}:{{ $l->product->product_name??'--' }}
                            </a>
                        </p>
                        <p class="project">{{ trans('custom.event') }}:{{ $l->task??'--' }}</p>
                        <p class="operators">{{ trans('custom.place') }}:{{ $l->location??'--' }}</p>
                        <p class="tool">{{$l->tool_type??'--'}}:{{ $l->tool??'--' }}</p>
                        <p class="explain">{{ trans('custom.note') }}:{{ $l->remark??'--' }}</p>
                        @if(!empty($l->more_info_url))
                        <p class="more"><a href="{{$l->more_info_url??''}}" target="_blank">
                                {{ trans('custom.more_info') }}</a>
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </section>
            @endif
            <div class="back_btn"><a href="{{ route('resumes.inquiry') }}">{{ trans('custom.back') }}</a></div>
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
                            $(this).find(".text").text("{{ trans('custom.verified') }}").show();
                        }
                        else{
                            $(this).removeClass("ok no").addClass("no");
                            $(this).find(".text").text("{{ trans('custom.unverified') }}").show();
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
        // 選擇日期事件
        function onDateSelected(id, fromModal) {
            $(".zabuto_calendar .table td.active").removeClass('active');
            $("#" + id).addClass('active');
            var date = $("#" + id).data("date");
            var hasEvent = $("#" + id).data("hasEvent");
            if (hasEvent) {
                $('#verification').scrollTo('[data-scroll='+date+']:first', 1000, 'swing');
                selectResume($('[data-scroll='+date+']:first'));
            }
        }
        var $productInfo = $('#rsu_info');
        var $productAlert = $('p.no_results');
        
        $('#verification .vfc_box').click(function(){
            $calendar.empty();
            $("#search").append("<div id='calendar'></div>")
            var dates = $(this).attr('data-scroll').split('-');
            $calendar = $("#calendar").zabuto_calendar({
                language: "en",
                data: @json($dates),
                today: false,
                show_days: true,
                year: dates[0],
                month: dates[1],
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
            $(".zabuto_calendar .table td.active").removeClass('active');
            $("#"+$calendar.attr('id')+"_"+$(this).attr('data-scroll')).addClass('active');
            // $("#"+$calendar.attr('id')+"_"+$(this).attr('data-scroll')).click();
            selectResume($(this));
        });

        function selectResume(resume){
            $('#verification .vfc_box.active').removeClass('active');
            resume.addClass('active');
            @if(request()->good)
            var id = {{ request()->good }};
            var type = 'good';
            @else
            var id = resume.attr('data-product');
            var type = 'product';
            @endif
            $productInfo.hide();
            $productAlert.html("\
            <div class='lds-ring'>\
                <div></div>\
                <div></div>\
                <div></div>\
                <div></div>\
            </div>").show();
            $.get( "{{ route('resumes.product')}}?id="+id+"&type="+type, function() {
                    // alert( "success" );
                })
                .done(function(data) {
                    $productAlert.hide();
                    $productInfo.find('p.harvesting em').text( data.product_name|| data.goods_name || '--' );
                    $productInfo.find('p.farm em').text( data.farm || '--' );
                    $productInfo.find('p.city em').text( data.city || '--' );
                    $productInfo.find('p.Township em').text( data.town || '--' );
                    $productInfo.find('p.address em').text( data.address || '--' );
                    $productInfo.find('p.tel em').text( data.tel || '--' );
                    var more = $productInfo.find('p.more em').html('');
                    if(data.more_info_url){
                        more.append("<a href='"+ data.more_info_url + "' target='_blank'>{{ trans('custom.more_info') }}</a>")
                    }
                    if(data.bc_url == null || data.bc_url == ""){
                        data.bc_url = "";
                    }
                    more.append("<a href='"+ data.bc_url + "' target='_blank'>{{ trans('custom.smart_contract') }}</a>");
                    $productInfo.show();
                })
                .fail(function(data) {
                    $productAlert.text(data.responseJSON.message);
                })
        }

    </script>
</body>

</html>