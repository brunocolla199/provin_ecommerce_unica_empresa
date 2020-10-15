$(document).ready(function() {

    var array = ["one","two","three","four"];
        
    $('.status').on('click',function(){
        var status = $(this).data('status');
        var classe = $(this).data('classe');

        backgroundTimeline(array,status);

        if(status == 3){
            $('#codRastreio').modal('show');
        }

        atualizastatus(status);
    });


    $('#salvarLink').on('click',function(){
        var link = $('#linkRastreamento').val();
        $('#link').val(link);
        $('#codRastreio').modal('hide');
    });


    $('#entregarPedido').on('click',function(){
        let status = $(this).data('status');
        let entregar = swal2_warning("Essa ação é irreversível!","Sim, entregar!");
        entregar.then(resolvedValue => {
            backgroundTimeline(array,status);
            swal2_success_not_reload("Entregue!", "Pedido entregue com sucesso.");
        }, error => {
            swal.close();
        });
    })
    

});

function backgroundTimeline(array,status)
{
    for (let index = 0; index < status; index++) {
        $('.'+array[index]).css("background","green");
    } 
}

function atualizastatus(status)
{
    var ultStatus = $('#ultStatus').val();
    if(status > ultStatus){
        $('#ultStatus').val(status);
    }
}