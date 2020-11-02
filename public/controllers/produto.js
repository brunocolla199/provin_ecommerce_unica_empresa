
$(document).ready(function(){
    
    $('#regPorPage,#ordenacao').on('change',function(){
        $('#itemPorPagina').submit();
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