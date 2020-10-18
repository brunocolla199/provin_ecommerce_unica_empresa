@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
@endsection

@section('page_title', __('page_titles.general.home'))

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            
            <p class="text-center  font-weight-bold" style="font-size: xx-large;">
                {{ Auth::user()->name }}
                <p class="text-center font-weight-bold" style="font-size: larger;"> @lang('home.welcome') </p>
            </p>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h4> @lang('home.title_personal_information') </h4>
                    
                    <ul class="list-icons">
                        <li><span href="javascript:void(0)" class="cursor-default"><i class="fa fa-chevron-right text-success"></i> @lang('home.email'): <span class="font-weight-bold">{{ Auth::user()->email }}</span> </span></li>
                        <li><span href="javascript:void(0)" class="cursor-default"><i class="fa fa-chevron-right text-success"></i> @lang('home.user'): <span class="font-weight-bold">{{ Auth::user()->username }}</span> </span></li>
                        <li><span href="javascript:void(0)" class="cursor-default"><i class="fa fa-chevron-right text-success"></i> @lang('home.administrator'): <span class="font-weight-bold">{{ Auth::user()->perfil->admin_controle_geral == 1 ? 'SIM' : 'NÃO' }}</span> </span></li>
                    </ul>    
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection