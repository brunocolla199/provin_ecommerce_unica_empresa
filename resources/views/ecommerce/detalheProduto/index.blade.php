@extends('layouts.app')

<style>
    #imagem-produto:hover {opacity: 0.7;}
    .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.9); 
    }
    .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    }
    #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
    }
    .modal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
    }
    @keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
    }

    .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    }

    .close:hover,
    .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
    }

    @media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
    }
</style>

@section('page_title', __('page_titles.ecommerce.detalheProduto.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ecommerce.produto') }}"> {{__('sidebar_and_header.ecommerce.product')}} </a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.detalheProduto.index') </li> 
@endsection

@section('content')
<div class="container">
    <!-- Single Product Body -->
    <div class="mb-14">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-5 mb-4 mb-md-0">
                <div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
                    data-infinite="true"
                    data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
                    data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
                    data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
                    data-nav-for="#sliderSyncingThumb">
                    <div class="js-slide">
                        <img class="img-fluid" id="imagem-produto" src="{{asset('ecommerce/assets/img/720X660/img1.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide">
                        <img class="img-fluid" id="imagem-produto" src="{{asset('ecommerce/assets/img/720X660/img2.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide">
                        <img class="img-fluid" id="imagem-produto" src="{{asset('ecommerce/assets/img/720X660/img3.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide">
                        <img class="img-fluid" id="imagem-produto" src="{{asset('ecommerce/assets/img/720X660/img4.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide">
                        <img class="img-fluid" id="imagem-produto" src="{{asset('ecommerce/assets/img/720X660/img5.jpg')}}" alt="Image Description">
                    </div>
                </div>

                <div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"
                    data-infinite="true"
                    data-slides-show="5"
                    data-is-thumbs="true"
                    data-nav-for="#sliderSyncingNav">
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid"  src="{{asset('ecommerce/assets/img/720X660/img1.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" src="{{asset('ecommerce/assets/img/720X660/img2.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" src="{{asset('ecommerce/assets/img/720X660/img3.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" src="{{asset('ecommerce/assets/img/720X660/img4.jpg')}}" alt="Image Description">
                    </div>
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" src="{{asset('ecommerce/assets/img/720X660/img5.jpg')}}" alt="Image Description">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4 mb-md-6 mb-lg-0">
                <div class="mb-2">
                    <a href="#" class="font-size-12 text-gray-5 mb-2 d-inline-block">{{$produto->produto_terceiro_id}}</a>
                    <h2 class="font-size-25 text-lh-1dot2">{{$produto->nome}}</h2>
                    <!--<div class="mb-2">
                        <a class="d-inline-flex align-items-center small font-size-15 text-lh-1" href="#">
                            <div class="text-warning mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="far fa-star text-muted"></small>
                            </div>
                            <span class="text-secondary font-size-13">(3 customer reviews)</span>
                        </a>
                    </div>
                    <a href="#" class="d-inline-block max-width-150 ml-n2 mb-2"><img class="img-fluid" src="{{asset('ecommerce/assets/img/200X60/img1.png')}}" alt="Image Description"></a>-->
                    @if($produto->grupo_produto_id == 31) 
                        <p class="font-size-16 text-lh-1dot2">{{__('page_titles.ecommerce.detalheProduto.descAneis')}} {{$tamanhosStr}}.</p>
                    @endif
                    <div class="mb-2">
                        <ul class="font-size-14 pl-3 ml-1 text-gray-110">
                            <!--<li>{{$produto->grupo->nome}}</li>-->
                            
                        </ul>
                    </div>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                    <p><strong>SKU</strong>: FW511948218</p>-->
                </div>
            </div>
            <div class="mx-md-auto mx-lg-0 col-md-6 col-lg-4 col-xl-3">
                <div class="mb-2">
                    <div class="card p-5 border-width-2 border-color-1 borders-radius-17">
                        <div class="text-gray-9 font-size-14 pb-2 border-color-1 border-bottom mb-3">{{__('sidebar_and_header.ecommerce.quantidade')}}: <span class="text-green font-weight-bold">{{$produto->quantidade_estoque}} {{__('sidebar_and_header.ecommerce.inEstoque')}}</span></div>
                        <div class="mb-3">
                        <div id="valorProduto" class="font-size-36">R${{number_format($produto->valor, 2, ',', '.')}}</div>
                        </div>
                        <div class="mb-3">
                            <h6 class="font-size-14">{{__('sidebar_and_header.ecommerce.quantidade')}}</h6>
                            <!-- Quantity -->
                            <div class="border rounded-pill py-1 w-md-60 height-35 px-3 border-color-1">
                                <div class="js-quantity row align-items-center">
                                    <div class="col">
                                    <input id="quantidadeProduto" class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="1" min="1" max="{{$produto->quantidade_estoque}}">
                                    </div>
                                    <div class="col-auto pr-1">
                                        <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" id="remove-btn" href="javascript:;">
                                            <small class="fas fa-minus btn-icon__inner"></small>
                                        </a>
                                        <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" id="add-btn" href="javascript:;">
                                            <small class="fas fa-plus btn-icon__inner"></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Quantity -->
                        </div>
                        {{-- <div class="mb-3">
                            <h6 class="font-size-14">Color</h6>
                            <!-- Select -->
                            <select class="js-select selectpicker dropdown-select btn-block col-12 px-0"
                                data-style="btn-sm bg-white font-weight-normal py-2 border">
                                <option value="one" selected>White with Gold</option>
                                <option value="two">Red</option>
                                <option value="three">Green</option>
                                <option value="four">Blue</option>
                            </select>
                            <!-- End Select -->
                        </div> --}}
                        @if($produto->grupo_produto_id == 31) 
                            <div class="mb-2 pb-0dot5">
                                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                                    @foreach ($tamanhos as $tamanho)
                                    <li class="page-link">{{ $tamanho }}</li>
                                        {{-- <li class="active page-link current"><span>{{ $tamanho }}</span></li>    --}}
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="mb-2 pb-0dot5">
                            <a href="#" class="btn btn-block btn-primary-dark"><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Carrinho Expresso</a>
                        </div>
                        <div class="mb-2 pb-0dot5">
                            <a href="#" class="btn btn-block btn-info" ><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Carrinho</a>
                        </div>
                        <div class="mb-3">
                            <a href="{{route('ecommerce.produto')}}" class="btn btn-block btn-dark">{{__('buttons.general.back')}}</a>
                        </div>
                        <!--<div class="flex-content-center flex-wrap">
                            <a href="#" class="text-gray-6 font-size-13 mr-2"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                            <a href="#" class="text-gray-6 font-size-13 ml-2"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Single Product Body -->
</div>

<div id="myModal" class="modal">
    <span class="close" id="fechar">&times;</span>
    <img class="modal-content" id="imagem-produto-modal">
    <div id="caption"></div>
</div>
@endsection

@section('footer')
    <script src="https://cdnjs.com/libraries/jquery.mask"></script>
    <script>
        var valorProduto = $('#valorProduto').html();
        valorProduto = valorProduto.substring(2);
        var valorFloat = parseFloat(valorProduto);

        $('#add-btn').click( function () {
            var quantidadeProduto = parseInt($('#quantidadeProduto').val());
            quantidadeProduto = quantidadeProduto + 1;
            $('#quantidadeProduto').val(quantidadeProduto.toString());
            var valorTotal = valorFloat * parseFloat($('#quantidadeProduto').val());
            $('#valorProduto').html("R$"+valorTotal.toFixed(2).toString().replace('.', ','));
        });

        $('#remove-btn').click( function () {
            if (parseInt($('#quantidadeProduto').val()) > 0) {
                var quantidadeProduto = parseInt($('#quantidadeProduto').val());
                quantidadeProduto = quantidadeProduto - 1;
                $('#quantidadeProduto').val(quantidadeProduto.toString());
                var valorTotal = valorFloat * parseFloat($('#quantidadeProduto').val());
                $('#valorProduto').html("R$"+valorTotal.toFixed(2).toString().replace('.', ','));
            }
        });
    </script>
    <script>
        var modal = document.getElementById("myModal");
        var img = document.getElementById("imagem-produto");
        var modalImg = document.getElementById("imagem-produto-modal");
        var captionText = document.getElementById("caption");

        img.onclick = function(){
            console.log("chama")
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        var span = document.getElementById("fechar");
        
        span.onclick = function() { 
            modal.style.display = "none";
        }
    </script>
@endsection