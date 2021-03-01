
<div class="regular slider" style="display: none" id="iconesCarrossel">
    @php
        $url = $_SERVER["REQUEST_URI"];
        $explode = explode('/',$url);
    @endphp
    <div>
        <a href="{{route('ecommerce.home')}}">
            <img  class="@if ($explode[2] == 'home') borda @endif iconeHome" src="{{asset('img/icones/s1.1.png')}}">
            <span style="display: flex;justify-content: center;font-size: 12px;width: 80%"> Início </span>
        </a>
        
    </div>
    <div>
        <a href="{{route('ecommerce.produto')}}">
            <img  class="@if ($explode[2] == 'produto') borda @endif iconeProduto" src="{{asset('img/icones/s2.2.png')}}">
            <span style="display: flex;justify-content: center;font-size: 12px;width: 80%"> Produtos </span>
        </a>
        
    </div>
    <div>
        <a href="{{route('ecommerce.pedido')}}">
            <img  class="@if ($explode[2] == 'pedido') borda @endif iconePedido" src="{{asset('img/icones/s3.3.png')}}">
            <span style="display: flex;justify-content: center;font-size: 12px;width: 80%"> Pedidos </span>
        </a>
        
    </div>
    <div>
        <a href="{{route('ecommerce.estoque')}}">
            <img  class="@if ($explode[2] == 'estoque') borda @endif iconeEstoque" src="{{asset('img/icones/s4.4.png')}}">
            <span style="display: flex;justify-content: center;font-size: 12px;width: 80%"> Estoque </span>
        </a>
        
    </div>
</div>
     