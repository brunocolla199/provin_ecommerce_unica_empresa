$(document).ready(function(){

    verifica();

    $('#tipo_pessoa').on('change',function(){
        verifica();
    });

    $('#cpf').on('blur',function(){
        var cpf = $(this).val();
        if(cpf != ''){
            if(!validaCPF(cpf)){
                $('#cpf').val('');
                swal2_alert_error_not_reload("CPF Inválido. Verifique !");                
            }
        }
    });

    $('#cnpj').on('blur',function(){
        var cnpj = $(this).val();
        if(cnpj != ''){
            if(!validaCNPJ(cnpj)){
                $('#cnpj').val('');
                swal2_alert_error_not_reload("CNPJ Inválido. Verifique !");                
            }
        }
    });

});

function verifica()
{
    console.log('entra');
    var tipo = $('#tipo_pessoa').val();
    if(tipo == 'F'){
        $('#divCNPJ').hide();
        $('#cnpj').removeAttr('required').val('');

        $('#divCPF').show();
        $('#cpf').attr('required',true);
    }else{
        $('#divCNPJ').show();
        $('#cnpj').attr('required',true);

        $('#divCPF').hide();
        $('#cpf').removeAttr('required').val('');
    }
}