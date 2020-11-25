

$(document).on("click",'.add-btn',function(){
    var id  = $(this).data('id');
    var qtdAtual = $('#qtd-'+id).val();
    var produto = $(this).data('produto');
    $('#qtd-'+id).val(parseInt(qtdAtual)+1);
    adicionaCarrinho(id,produto,qtdAtual, 1);
});

$(document).on("click",'.remove-btn',function(){
    var id  = $(this).data('id');
    var qtdAtual = $('#qtd-'+id).val();
    var produto = $(this).data('produto');
    if(parseInt(qtdAtual) >= 2){ 
        removeCarrinho(id,produto,qtdAtual,1);
    }else{
        swal2_alert_error_not_support('A quantidade não pode ser zerada.');        
    } 
});

$(document).on("change",'.qtd',function(){
    var id  = $(this).data('id');
    var qtdNova = $('#qtd-'+id).val();
    var produto = $(this).data('produto');
    if(qtdNova <= 0){
        swal2_alert_error_support('Quantidade inválida.');
    }
    consultaItemCarrinho(id).then(function(retorno){
        if(retorno.quantidade > qtdNova){
            removeCarrinho(id,produto,retorno.quantidade,parseInt(retorno.quantidade) - parseInt(qtdNova));
        }else{
            adicionaCarrinho(id,produto,retorno.quantidade, parseInt(qtdNova) - parseInt(retorno.quantidade)); 
        }
    });
    
    
    
});

$(document).on("change",'.tamanho',function(){
    var id      = $(this).data('id');
    alteraCarinho(id).catch(function(error_msg){
        swal2_alert_error_support(error_msg);
    });
});


function adicionaCarrinho(id,produto, qtdAtual, qtdAdicionada)
{
    consultaProduto(produto).then(function(retorno){
        let estoque = retorno.quantidade_estoque;
        if(parseInt(qtdAdicionada) > estoque)
        {
            swal2_alert_error_not_support('Estoque indisponível.');
            $('#qtd-'+id).val(parseInt(qtdAtual));
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
        $('#qtd-'+id).val(parseInt(qtdAtual)-qtdRemovida);
        calculaValorProduto(id,retorno.preco,parseInt(qtdAtual)-parseInt(qtdRemovida));
        alteraProduto(produto,qtdRemovida,'A').then(function(ret){
        });    
    });

}


function consultaProduto(id)
{
    return new Promise((resolve,reject)=>{
        $.ajax({
            type: "GET",
            url: '../../produto/buscaProduto/'+id,
            success: function (retorno) {
                if(retorno.response == 'erro') {
                    reject(data.msg);
                }
                resolve(retorno.data);
            },
            error: function (retorno, textStatus, errorThrown) {
                reject("Tivemos um problema ao consultar o produto item.");
            },
        });
    });
}

function consultaItemCarrinho(id)
{
    return new Promise((resolve,reject)=>{
        $.ajax({
            type: "GET",
            url: '../../carrinho/buscaItem/'+id,
            success: function (retorno) {
                if(retorno.response == 'erro') {
                    reject(data.msg);
                }
                resolve(retorno.data);
            },
            error: function (retorno, textStatus, errorThrown) {
                reject("Tivemos um problema ao consultar o produto item.");
            },
        });
    });
}



function calculaValorProduto(id,valor, qtd) {
    var valorTotal = valor * parseFloat(qtd);
    var valorTotalAux = valorTotal.toFixed(2).toString().replace('.', ',');
    $('#total-'+id).html(valorTotalAux);
    calculaValorTotal();
    alteraCarinho(id).catch(function(error_msg){
        swal2_alert_error_support(error_msg);
    });
}

function calculaValorTotal(){
    var subTotal = 0;
    $('.total').each(function(index,value){
        var id = value.id;
        subTotal += parseFloat($('#'+id).text().replace(',', '.'));
    });
    var subTotalAux = subTotal.toFixed(2).toString().replace('.', ',');
    var acrescimos  = parseFloat($('#adicional').text().substr(2).replace(',', '.'));
    $('#subTotal').html("R$ "+subTotalAux);
    var totalGeral = (subTotal + acrescimos).toFixed(2).toString().replace('.', ',');
    $('#total').html("R$ "+subTotalAux)
}


