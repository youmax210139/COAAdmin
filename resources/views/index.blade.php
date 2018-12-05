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
        #core .con {
          color: #666666;
          word-break: normal;
          font-size: 16px;
          line-height: 24px;
        }
        #core .con p{
          margin-bottom: 30px;
        }

        #core .con li p{
          padding-top: 20px;
        }

        @media (min-width: 1024px) {
          /* line 365, ../sass/module/_layout.scss */
          #core .con {
            font-size: 18px;
            line-height: 34px;
          }
        }
        #core h4 {
          text-align: center;
          color: #66a371;
          line-height: 24px;
          margin: 0 0 15px 0;
        }
        @media (min-width: 1024px) {
          /* line 377, ../sass/module/_layout.scss */
          #core h4 {
            line-height: 30px;
            margin: 0 0 30px 0;
          }
        }
    </style>
</head>

<body id="index">
    <div id="navbar_top"> <a id="rwd_nav" href="#m_nav">
            <div class="ico"><span></span></div>
        </a> </div>
    <!--上版-->
    <header id="header">
        <div class="inner">
            <div id="header_logo">
                <a href="index.html">
                    <img src="images/logo.svg" alt="農業產品產銷履歷區塊鏈資訊網">
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
            <div id="banner">
                <div class="img"><img src="images/banner_img.svg"></div>
                <div class="info">
                    <div class="txt">
                        <h2>產銷履歷加菜金隆重登場</h2>
                        <p>獎金獎品再升級</p>
                        <p>一年一度走過路過千萬別錯過</p>
                        <p>買越多鐘獎機會多更多</p>
                        <p>手刀火速參加</p>
                    </div>
                    <div class="search_box">
                        <form action="" method="get" autocomplete="off">
                            <input name="gnb_search" type="text" class="srch_input" placeholder="請輸入履歷追溯碼">
                            <button type="submit" class="ico_enter"><span class="blind">搜尋</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="inner">
            <section id="about">
                <h2 class="tit"><span>什麼是產銷履歷?</span></h2>
                <div class="con">
                    <h4>農產品產銷履歷制度<br>
                        臺灣良好農業規範實施及驗證＋履歷追溯體系</h4>
                    <p>依據「農產品生產及驗證管理法」所推動的自願性農產品產銷履歷制度，即結合上述兩大國際農產品管制制度，同時採取臺灣良好農業規範（Taiwan Good Agriculture
                        Practice，簡稱TGAP）的實施與驗證，以及建立履歷追溯體系。簡言之，購買使用產銷履歷農產品標章（如附圖1）的產銷履歷農產品，不只可以從「產銷履歷農產品資訊網」(http://taft.coa.gov.tw)查詢到農民的生產紀錄，也代表驗證機構已經為您親赴農民的生產現場，去確認農民所記是否符合所做、所做是否符合規範，並針對產品行抽驗，而每一批產品的相關紀錄也在驗證機構的監控下，嚴格審視，一有問題就會馬上處置，因此可以有效降低履歷資料造假的風險，並且有效管控生產過程不傷害環境、產品不傷害人體。
                    </p>
                </div>
            </section>
            <section id="core">
                <h2 class="tit">什麼是區塊鏈?</h2>
                <div class="con">
                    <p>區塊鏈建立在對等式網路（peer-to-peer，簡稱P2P）上的分散式帳本技術，參與區塊鏈的用戶可以在自己的電腦上架設一個節點，與其他節點資料同步資料，應用密碼學的加密技術，實現無法被竄改的資料庫。因為區塊鏈可以詳細記錄每一筆資料，且可以驗證每一筆資料，用於農產品的產銷履歷非常適合。</p>
                    <h4>核心價值</h4>
                    <ul>
                        <li>
                            <a href="#">
                                <span class="img"><img src="images/core_img01.svg"></span>
                                <span class="txt">可溯源</span>
                            </a>
                            <p>區塊鏈詳細記錄每一筆資料，可以作為農產品的溯源資料庫</p>
                        </li>
                        <li>
                            <a href="#">
                                <span class="img"><img src="images/core_img02.svg"></span>
                                <span class="txt">去中心化</span>
                            </a>
                            <p>傳統的資料庫由單一的伺服器所控制，區塊鏈則由所有參與的節點共同維護</p>
                        </li>
                        <li>
                            <a href="#"><span class="img">
                                    <img src="images/core_img03.svg"></span>
                                <span class="txt">無法竄改</span>
                            </a>
                            <p>透過密碼學的機制，可以驗證資料的正確性</p>
                        </li>
                        <li>
                            <a href="#"><span class="img">
                                    <img src="images/core_img04.svg"></span>
                                <span class="txt">資料透明</span>
                            </a>
                            <p>資料都是透明的，任何人都可以取得區塊鏈上的資料</p>
                        </li>
                    </ul>
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
        });

    </script>
</body>

</html>
