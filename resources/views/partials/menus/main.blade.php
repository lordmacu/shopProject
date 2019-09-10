<ul class="site-menu js-clone-nav d-none d-lg-block">
    @foreach($items as $menu_item)
        <li>
            <a href="{{countryRoute($menu_item->route)}}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @endif
            </a>
        </li>
    @endforeach
         @guest
    <li><a href="{{ route('register') }}">Sign Up</a></li>
    <li><a href="{{ route('login') }}">Login</a></li>
    @else
    <li>
        <a href="{{ countryRoute("users.edit") }}">My Account</a>
    </li>
    <li>
        <a href="{{ countryRoute("logout") }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

    <form id="logout-form" action="{{countryRoute("logout") }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
    <li><a href="{{ route('country.cart.index',\Session::get('country')->slug) }}">Cart
    @if (Cart::instance('default')->count() > 0)
    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
    @endif
    </a></li>
    {{-- @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @endif
            </a>
        </li>
    @endforeach --}}
 

</ul>
