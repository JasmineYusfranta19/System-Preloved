@extends('layouts.tailwind_app')
@section('title', 'Preloved.id — Jual Beli Pakaian Preloved Terpercaya')

@section('content')

    <!-- Header / Navbar Component -->
    <x-header />

    <!-- Hero Section Component -->
    <x-hero />

    <!-- Categories Section Component -->
    <x-kategori :categories="$categories" />

    <!-- Promo Banners Section Component -->
    <x-promo-banners />

    <!-- Features Section Component -->
    <x-features />

    <!-- Latest Products Section Component -->
    <x-product-grid :products="$latestProducts" />

    <!-- Footer Component -->
    <x-footer />

@endsection