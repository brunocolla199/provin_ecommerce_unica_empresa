@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.home.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
@endsection

@section('content')
    dashbord
@endsection