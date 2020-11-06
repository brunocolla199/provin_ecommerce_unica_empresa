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
        $('#divCNPJ, #divIE').hide();
        $('#cnpj, #ie').removeAttr('required').val('');

        $('#divCPF, #divRG').show();
        $('#cpf, #rg').attr('required',true);
    }else{
        $('#divCNPJ, #divIE').show();
        $('#cnpj, #ie').attr('required',true);

        $('#divCPF, #divRG').hide();
        $('#cpf, #rg').removeAttr('required').val('');
    }
}