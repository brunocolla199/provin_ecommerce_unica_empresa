var img = document.getElementById("imagem-produto");
var modal = document.getElementById("myModal");


//MONTA MODAL
$(document).on("click",'.img-fluid',function(){
    var modalImg = document.getElementById("imagem-produto-modal");
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
});

$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27) {
		modal.style.display = "none";
    }
});

$(Document).on('click','#myModal',function(){
    modal.style.display = "none";
});

var span = document.getElementById("fechar");

span.onclick = function() { 
    modal.style.display = "none";
}

//CALCULA VALOR
var valorFloat = parseFloat($('#valorUnitario').text().substr(2).replace(',','.'));

$(document).on("click",'.add-btn',function(){
    var id  = $(this).data('id');
    var qtdAtual = $('#quantidadeProduto').val();
    var produto = $(this).data('produto');
    $('#quantidadeProduto').val(parseInt(qtdAtual)+1);
    adicionaCarrinho(id,produto,qtdAtual, 1);
    
});

$(document).on("click",'.remove-btn',function(){
    var id  = $(this).data('id');
    var qtdAtual = $('#quantidadeProduto').val();
    var produto = $(this).data('produto');
    if(parseInt(qtdAtual) >= 2){ 
        removeCarrinho(id,produto,qtdAtual,1);
    }else{
        swal2_alert_error_not_support('A quantidade não pode ser zerada.');        
    }
});

$('.tamanho').on('click',function(){
    var tamanho = $(this).text();
    $(".tamanho").each(function(index, value){;
        $('#'+value.id).removeAttr('class').attr('class','page-link tamanho').attr('data-selected',false);
    });
    $('#tamanho-'+tamanho).attr('data-selected',true).attr('class','page-link current tamanho');
    var id      = $('#idItemCarrinho').val();
    alteraCarinho(id).catch(function(error_msg){
        swal2_alert_error_support(error_msg);
    });
});


$(document).on("change",'.qtd',function(){
    var id  = $(this).data('id');
    var qtdNova = $('#quantidadeProduto').val();
    var produto = $(this).data('produto');
    
    if(qtdNova <= 0){
        swal2_alert_error_support('Quantidade inválida.');
    }else{
        consultaItemCarrinho(id).then(function(retorno){
            if(retorno.quantidade > qtdNova){
                removeCarrinho(id,produto,retorno.quantidade,parseInt(retorno.quantidade) - parseInt(qtdNova));
            }else{
                adicionaCarrinho(id,produto,retorno.quantidade, parseInt(qtdNova) - parseInt(retorno.quantidade)); 
            }
        });
    } 
});

function adicionaCarrinho(id,produto, qtdAtual, qtdAdicionada)
{
    consultaProduto(produto).then(function(retorno){
        let estoque = retorno.quantidade_estoque;
        if(parseInt(qtdAdicionada) > estoque)
        {
            swal2_alert_error_not_support('Estoque indisponível.');
            $('#quantidadeProduto').val(parseInt(qtdAtual));
        }else{ 
            calculaValorProduto(id,retorno.preco,parseInt(qtdAtual)+parseInt(qtdAdicionada));
            alteraProduto(produto,qtdAdicionada,'S').then(function(retorno){
            });
        }
    });
}

function removeCarrinho(id, produto, qtdAtual, qtdRemovida)
{
    consultaProduto(produto).then(function(retorno){
        let estoque = retorno.quantidade_estoque;
        $('#quantidadeProduto').val(parseInt(qtdAtual)-qtdRemovida);
        calculaValorProduto(id,retorno.preco,parseInt(qtdAtual)-parseInt(qtdRemovida));
        alteraProduto(produto,qtdRemovida,'A').then(function(ret){
        });    
    });

}




function calculaValorProduto(id,valor, qtd) {
    var valorTotal = valor * parseFloat(qtd);
    var valorTotalAux = valorTotal.toFixed(2).toString().replace('.', ',');
    $('#valorProduto').html("R$ "+valorTotalAux);
    alteraCarinho(id).catch(function(error_msg){
        swal2_alert_error_support(error_msg);
    });
}
