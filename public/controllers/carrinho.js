$(document).on("click",'.remove-btn',function(){
    var id  = $(this).data('id');
    var valorFloat = parseFloat($('#preco-'+id).text().replace(',','.'));
    var qtd = $('#qtd-'+id).val();
    if(parseInt(qtd) >= 2){
        $('#qtd-'+id).val(parseInt(qtd)-1);
        calculaValorProduto(id,valorFloat,parseInt(qtd)-1);
    } 
});

$(document).on("click",'.add-btn',function(){
    var id  = $(this).data('id');
    var valorFloat = parseFloat($('#preco-'+id).text().replace(',','.'));
    var qtd = $('#qtd-'+id).val();
    var qtd_estoque = $('#estoque-'+id).val();
    
    if(parseInt(qtd) < parseInt(qtd_estoque)){
        $('#qtd-'+id).val(parseInt(qtd)+1);
        calculaValorProduto(id,valorFloat,parseInt(qtd)+1);
    } 
});

$(document).on("change",'.tamanho',function(){
    var id      = $(this).data('id');
    alteraCarinho(id).catch(function(error_msg){
        swal2_alert_error_support(error_msg);
    });
});

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


