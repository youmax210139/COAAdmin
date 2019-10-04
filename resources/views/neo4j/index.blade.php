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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/popoto/dist/popoto.min.css">
    <style>
        #popoto-graph:fullscreen {
            width: 100%;
            height: 100%;
        }

        #popoto-graph:-webkit-full-screen {
            width: 100%;
            height: 100%;
        }

        #popoto-graph:-moz-full-screen {
            width: 100%;
            height: 100%;
        }

        #popoto-graph:-ms-fullscreen {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body id="page" class="resumeInq">
    <div id="navbar_top"> <a id="rwd_nav" href="#m_nav">
            <div class="ico"><span></span></div>
        </a> </div>
    <!--上版-->
    @include('partials.header')
    <main id="main">
        <div class="inner">
            <section class="ppt-section-main">
                <div class="ppt-section-header">
                    <span class="ppt-header-span">Graph</span> search
                </div>

                <div class="ppt-container-graph">
                    <nav id="popoto-taxonomy" class="ppt-taxo-nav">
                        <!-- Label/taxonomy filter will be generated here -->
                    </nav>
                    <div id="popoto-graph" class="ppt-div-graph">
                        <!-- Graph will be generated here-->
                    </div>
                </div>

                <div id="popoto-query" class="ppt-container-query">
                    <!-- Query viewer will be generated here -->
                </div>

                <div id="popoto-cypher" class="ppt-container-cypher">
                    <!-- Cypher query viewer will be generated here -->
                </div>

                <div class="ppt-section-header">
                    <!-- The total results count is updated with a listener defined below -->
                    RESULTS <span id="result-total-count" class="ppt-count"></span>
                </div>

                <div id="popoto-results" class="ppt-container-results">
                    <!-- Results will be generated here -->
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
    <script src="https://unpkg.com/jquery" charset="utf-8"></script>
    <script src="https://unpkg.com/d3" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/popoto/dist/popoto.min.js"></script>
    <script>
        /**
     * URL used to access Neo4j REST API to execute queries.
     * Update this parameter to your running server instance.
     *
     * For more information on Neo4J REST API the documentation is available here: http://neo4j.com/docs/stable/rest-api-cypher.html
     */
    popoto.rest.CYPHER_URL = "{{env('CYPHER_URL')}}";
    /**
     * Add this authorization property if your Neo4j server uses basic HTTP authentication.
     * The value of this property must be "Basic <payload>", where "payload" is a base64 encoded string of "username:password".
     *
     * "btoa" is a JavaScript function that can be used to encode the user and password value in base64 but it is recommended to directly use the Base64 value.
     *
     *  For example Base64 encoded value of "neo4j:password" is "bmVvNGo6cGFzc3dvcmQ="
     *  Note that it is not a safe way to keep credentials as anyone can have access to this code in your web page.
     */
    popoto.rest.AUTHORIZATION = "Basic " + btoa("{{env('AUTHORIZATION')}}");
    /**
     * Define the Label provider you need for your application.
     * This configuration is mandatory and should contain at least all the labels you could find in your graph model.
     *
     * In this version only nodes with a label are supported.
     *
     * By default If no attributes are specified Neo4j internal ID will be used.
     * These label provider configuration can be used to customize the node display in the graph.
     * See www.popotojs.com or example for more details on available configuration options.
     */
    popoto.provider.node.Provider = {
        "農場": {
            "returnAttributes": ["name", "city"],
            "constraintAttribute": "name",
            "autoExpandRelations": true // if set to true Person nodes will be automatically expanded in graph
        },
        "產品": {
            "returnAttributes": ["name"],
            "constraintAttribute": "name",
            "autoExpandRelations": true // if set to true Person nodes will be automatically expanded in graph
        },
    };
    /**
     * Here a listener is used to retrieve the total results count and update the page accordingly.
     * This listener will be called on every graph modification.
     */
    popoto.result.onTotalResultCount(function (count) {
        document.getElementById("result-total-count").innerHTML = "(" + count + ")";
    });
    /**
     * The number of results returned can be changed with the following parameter.
     * Default value is 100.
     *
     * Note that in this current version no pagination mechanism is available in displayed results
     */
    popoto.query.RESULTS_PAGE_SIZE = 100;
    /**
     * For this version, popoto.js has been generated with debug traces you can activate with the following properties:
     * The value can be one in DEBUG, INFO, WARN, ERROR, NONE.
     *
     * With INFO level all the executed cypher query can be seen in the navigator console.
     * Default is NONE
     */
    popoto.logger.LEVEL = popoto.logger.LogLevels.INFO;
    /**
     * Start popoto.js generation.
     * The function requires the label to use as root element in the graph.
     */
    popoto.start("農場");
    </script>
</body>

</html>