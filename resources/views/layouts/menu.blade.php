@if (Auth::guest())
    <li><a href="{{ url('/login') }}"> {{trans('app.Login')}}</a></li>
   <!-- <li><a href="{{ url('/register') }}">{{trans('app.Register')}}</a></li> -->
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ route('getUserProfile',['name'=>str_slug( Auth::user()->name),'id'=> Auth::user()->id])  }}">
                    {{trans('app.Profile')}}
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    {{trans('app.Logout')}}
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
@endif