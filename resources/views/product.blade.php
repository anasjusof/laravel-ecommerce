@extends('layout')

@section('title', 'Product')

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="#">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{ route('shop.index') }}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{ $product->name }}</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="product-section container">
        <div class="product-section-image">
            <img src="{{ asset('img/macbook-pro.png') }}" alt="product">
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>
                {{ $product->description }}
            </p>

            <p>&nbsp;</p>

            {{-- <a href="" class="button"> Add to Cart </a> --}}

            <form action="{{ route('cart.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <button class="button button-plain">Add to Cart</button>
            </form>

            
        </div>
    </div> <!-- end product-section -->

    <div class="might-like-section">
        <div class="container">
            <h2>You might also like...</h2>
            <div class="might-like-grid">
                @foreach($mightAlsoLike as $product)
                <div class="might-like-product">
                    <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ asset('img/macbook-pro.png') }}" alt="product"></a>
                    <div class="might-like-product-name">{{ $product->name }}</div>
                    <div class="might-like-product-price">{{ $product->presentPrice() }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection