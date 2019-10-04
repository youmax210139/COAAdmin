<header id="header">
    <div class="inner">
        <div id="header_logo">
            <a href="{{route('homes.index')}}">
                <img src="{{ asset("images/logo_".app()->getLocale().".svg") }}" alt="{{ trans('custom.page_title') }}">
            </a>
        </div>
        <nav id="header_nav">
            <div id="m_nav">
                <div id="menu">
                    <ul class="menu">
                        <li class="{{ (request()->route()->getName()=='homes.index')?'active':'' }}">
                            <a href="{{ route('homes.index','#about') }}"
                                title="{{ trans('custom.traceabilty_about') }}" data-scroll="#about">
                                {{ trans('custom.traceabilty_about') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homes.index','#core') }}" title="{{ trans('custom.blockchain_about') }}"
                                data-scroll="#core">
                                {{ trans('custom.blockchain_about') }}
                            </a>
                        </li>
                        <li class="{{ (request()->route()->getName()=='resumes.inquiry')?'active':'' }}">
                            <a href="{{ route('resumes.inquiry') }}" title="{{ trans('custom.resume_search') }}">
                                {{ trans('custom.resume_search') }}
                            </a>
                        </li>
                        <li class="{{ (request()->route()->getName()=='resumes.index'&&empty($request->query()))?'active':'' }}">
                            <a href="{{ route('resumes.index') }}"
                                title="{{ trans('custom.resume_latest') }}">
                                {{ trans('custom.resume_latest') }}
                            </a>
                        </li>
                        @if(config('setting.neo4j'))
                        <li class="{{ (request()->route()->getName()=='neo4j.view')?'active':'' }}">
                            <a href="{{ route('neo4j.index') }}" title="neo4j">
                                Neo4j
                            </a>
                        </li>
                        @endif
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