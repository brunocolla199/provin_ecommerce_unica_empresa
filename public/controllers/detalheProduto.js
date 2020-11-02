var img = document.getElementById("imagem-produto");
var modal = document.getElementById("myModal");


$(document).on("click",'.img-fluid',function(){
    console.log("chama")
    
    var modalImg = document.getElementById("imagem-produto-modal");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
});

var span = document.getElementById("fechar");

span.onclick = function() { 
    modal.style.display = "none";
}

var valorFloat = parseFloat($('#valorProduto').text().substr(2).replace(',','.'));

$('.tamanho').on('click',function(){
    var tamanho = $(this).text();
    $(".tamanho").each(function(index, value){
        $('#'+value.id).removeAttr('class').attr('class','page-link tamanho');
    });
    $('#tamanho-'+tamanho).attr('data-selected',true).attr('class','page-link current tamanho');
});

$('.add-cart').on('click',function(){
    var id   = $(this).data('id');
    var tipo = $(this).data('tipo');
    var quantidade = $('#quantidadeProduto').val();
    var tamanho = '';
    $('.tamanho').each(function(index,value){
        var id = value.id;
        if($('#'+id).data('selected') == true){
            tamanho = $('#'+id).text();
        }
    });
    

    var descricaoCarrinho = tipo == 'express' ? ' expresso' : ' de compras';

    let add_carrinho = swal2_warning("Essa ação irá adicionar o produto ao carrinho"+descricaoCarrinho ,"Sim!");
    

    add_carrinho.then(resolvedValue => {
        $.ajax({
            type: "POST",
            url: '../adicionarCarinho',
            data: { id: id, tipo: tipo, tamanho:tamanho, quantidade:quantidade, _token: '{{csrf_token()}}' },
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

$(document).on("click",'#add-btn',function(){
    var qtd = $('#quantidadeProduto').val();
    var qtd_estoque = $('#qtdEstoque').text();
    if(parseInt(qtd) < parseInt(qtd_estoque)){
        $('#quantidadeProduto').val(parseInt(qtd)+1);
        calculaValorProduto(valorFloat);
    }
    
});

$(document).on("click",'#remove-btn',function(){
    var qtd = $('#quantidadeProduto').val();
    if(parseInt(qtd) >= 2){
        $('#quantidadeProduto').val(parseInt(qtd)-1);
        calculaValorProduto(valorFloat);
    } 
});


function calculaValorProduto(valor) {
    var quantidadeProduto = parseInt($('#quantidadeProduto').val());
    $('#quantidadeProduto').val(quantidadeProduto.toString());
    var valorTotal = valor * parseFloat($('#quantidadeProduto').val());
    $('#valorProduto').html("R$"+valorTotal.toFixed(2).toString().replace('.', ','));
}

