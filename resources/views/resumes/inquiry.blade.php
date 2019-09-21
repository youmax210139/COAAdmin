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
</head>

<body id="page" class="resumeInq">
    <div id="navbar_top"> <a id="rwd_nav" href="#m_nav">
            <div class="ico"><span></span></div>
        </a> </div>
    <!--上版-->
    @include('partials.header')
    <main id="main">
        <div class="inner">
            <section id="rsu_inquire">
                <div class="tit {{ session('locale') }}">
                    <h1><span>{{ trans('custom.resume_search') }}</span></h1>
                </div>
                <div class="con">
                    <form action="{{ route('resumes.index') }}" method="get" id="search_form">
                        <div class="form_group">
                            <label for="select_teaField">{{ trans('custom.farm') }}</label>
                            <select class="form-control" id="select_farmField" name="farm">
                                <option value=''>{{ trans('custom.all') }}</option>
                                @foreach($farms as $key=>$val)
                                <option value="{{ urlencode($key) }}">{{ str_replace('"', '', $val) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="errMsg" style="color:red;display:none">
                            <h3>錯誤:</h3>
                            <p></p>
                        </div>
                        <div class="form_group" id="good_group" style="display:none;">
                            <label for="select_cropNum">{{ trans('custom.crop_code') }}</label>
                            <select class="form-control" id="select_goodField" name="goods">
                            </select>
                        </div>
                        <div class="form_btn">
                            <div class="submit_btn">
                                <button type="submit" class="btn">{{ strtolower(trans('custom.search')) }}</button>
                            </div>
                            <div class="reset_btn">
                                <button type="reset" class="btn ">{{ trans('custom.clean') }}</button>
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
            var $good_group = $('#good_group');
            var $select_goodField = $('#select_goodField');
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
                $good_group.hide();
                $select_goodField.html("").prop('disabled', 'disabled');
                if (value) {
                    $select_farmField.prop('disabled', 'disabled');
                    $submit_btn.prop('disabled', 'disabled');
                    var $ajaxError = function(r, textStatus, err){
                        var e = JSON.parse(r.responseText);
                        $errMsg.show().find('p').text(JSON.stringify(e.errors));
                    };

                    $.ajax({
                        url: "{{ route('resumes.good') }}",
                        type: 'GET',
                        data: {farm: value},
                        success: function (response, textStatus, jqXhr) {
                            if(response.length == 0){
                                return $ajaxError({"responseText":"{\"errors\":\"{{__('custom.empty_good')}}\"}"}, textStatus, null);
                            }
                            $.each(response, function(key,val){
                                $select_goodField.append("<option value="+ encodeURI(key) + ">" + val + "</option>")
                            });
                            $select_goodField.prop('disabled', false);
                            $good_group.show();
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
