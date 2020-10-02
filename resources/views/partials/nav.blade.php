<header>
    <div class="top-nav container">
        <div class="logo">Laravel Ecommerce</div>
        <ul>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
            <li>
                <a href="{{ route('cart.index') }}">
                    Cart<span class="cart-count"><span>
                    @if(Cart::instance('default')->count() > 0)
                    <span style="margin: 0; padding: 0;">{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                </a>
            </li>
        </ul>
    </div> <!-- end top-nav -->
</header>