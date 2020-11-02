
$(document).ready(function(){
    
    $('#regPorPage,#ordenacao').on('change',function(){
        $('#itemPorPagina').submit();
    });


    $('.btn-add-cart').on('click',function(){
        var id   = $(this).data('id');
        var tipo = $(this).data('tipo');
        var tamanho = $('#tamanho-'+id).val();
        var descricaoCarrinho = tipo == 'express' ? ' expresso' : ' de compras';

        let add_carrinho = swal2_warning("Essa ação irá adicionar o produto ao carrinho"+descricaoCarrinho ,"Sim!");
        let obj = {'id': id};

        add_carrinho.then(resolvedValue => {
            $.ajax({
                type: "POST",
                url: 'produto/adicionarCarinho',
                data: { id: id, tipo: tipo, tamanho:tamanho,quantidade:1, _token: '{{csrf_token()}}' },
                success: function (data) {
                    if(data.response != 'erro') {
                        swal2_success("Adicionado !", "Produto adicionado com sucesso.");
                    } else {
                        swal2_alert_error_support("Tivemos um problema ao adicionar o produto.");
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }, error => {
            swal.close();
        });
    });

});

function verificavalore(){
    event.preventDefault();
    var minimo = $('.rangeMinimo').text();
    var maximo = $('.rangeMaximo').text();

    $('#rangeMinimo').val(minimo);
    $('#rangeMaximo').val(maximo);

    $('#filtroValor').removeAttr('onsubmit').submit();
    
}

function verificavalore_mob(){
    event.preventDefault();
    var minimo = $('.rangeMinimo_mob').text();
    var maximo = $('.rangeMaximo_mob').text();

    $('#rangeMinimo_mob').val(minimo);
    $('#rangeMaximo_mob').val(maximo);

    $('#filtroValor_mob').removeAttr('onsubmit').submit();
    
}