"use strict";


/*=========================================
            AJAX Request
=========================================*/

/**
 * 
 * @param {*} method the HTTP request method (POST, GET...)
 * @param {*} url the url request
 * @param {*} obj any JSON object that you want
 */
function ajaxMethod(method, url, obj) {
    return new Promise((resolve, reject) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: method,
            url: url,
            dataType: 'JSON',
            data: obj,
            success: data => {
                resolve(data);
            }, error: err => {
                reject(err);
            }
        });
    });
}




/*=========================================
            SweetAlert2 Custom
=========================================*/

/**
 * Warning Message
 * 
 * @param {*} text message that will be displayed for more details of the consequence of the action
 */
function swal2_warning(text, buttonText = 'Sim, excluir!', colorConfirm = "#DD6B55" ) {
    return new Promise((resolve, reject) => {
        swal({   
            title: "Você tem certeza?",   
            text: text,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: colorConfirm,   
            confirmButtonText: buttonText,   
            cancelButtonText: "Cancelar",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                resolve(true);
            } else {     
                reject(false);
            }  
        });
    });
}

function swal2_alert_question(titulo,text, buttonText = 'Sim !', colorConfirm = "#DD6B55" ) {
    return new Promise((resolve, reject) => {
        swal({   
            title: titulo,   
            text: text,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: colorConfirm,   
            confirmButtonText: buttonText,   
            cancelButtonText: "Fechar",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                resolve(true);
            } else {     
                reject(false);
            }  
        });
    });
}

/**
 * Input Message
 * 
 * @param {*} text message that will be displayed for more details of the consequence of the action
 */
function swal2_input(text, placeholder, msg_erro) {
    return new Promise((resolve, reject) => {
        swal({
            title: text,
            text: '',
            type: "input",
            name: "nameDashboard",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: placeholder
        },
        function(inputValue){
            if (inputValue === false) return false;
  
            if (inputValue === "") {
                swal.showInputError(msg_erro);
                return false;
            }
            //swal2_success("Sucesso!","Dashboard: " + inputValue +" cadastrado com sucesso.")
            //swal("Sucesso!", "Dashboard: " + inputValue +" cadastrado com sucesso.", "success");
            resolve(inputValue);
        });
    });    
}

/**
 * Success Message and Page Reload
 * 
 * @param {*} tile alert title message
 * @param {*} text message that will be displayed for more details of the consequence of the action
 */
function swal2_success(title, text) {
    swal({   
        title: title,   
        text: text,
        type: "success"
    }, function(){   
        location.reload();  
    });
}

function swal2_success_not_reload(title, text) {
    swal({   
        title: title,   
        text: text,
        type: "success"
    }, function(){   
         
    });
}

/**
 * Error Message and Page Reload
 */
function swal2_alert_error_support(text) {
    swal({
        title: "Ops!",   
        text: text + " Por favor, contate o suporte técnico!",
        type: "warning"
    }, function(){   
        location.reload();  
    });
}

/**
 * Error Message and not Page Reload
 */
function swal2_alert_error_not_reload(text) {
    swal({
        title: "Ops!",   
        text: text ,
        type: "warning"
    }, function(){   
        
    });
}





/*=========================================
            toastr.js
=========================================*/

/**
 * Simple method to generalize the display of a toastr
 * 
 * @param {*} h toastr title message
 * @param {*} t toastr description/body content
 * @param {*} i define the toastr type, e.g.: info, warning, success and error
 */
function showToast(h, t, i) {
    $.toast({
        heading: h,
        text: t,
        position: 'top-right',
        loaderBg:'#ff6849',
        icon: i,
        hideAfter: 3500, 
        stack: 6
    });
}


function createFiltersComponentsGED($_indices, $_component, $_infoInputs, $_size_col_md = 4, $_required = false) {

    let components = "";
    let idTipoIndice = "";
    let infoInput = "";
    let required = "";

    $.each($_indices, function (idx, el) {

        components += '<div class="col-md-4">';
        idTipoIndice = el.idTipoIndice;
        infoInput = $_infoInputs[idTipoIndice];

        components += "<label>" + el.descricao + "</label>";                            

        if ($_required) {
            required = el.preenchimentoObrigatorio ? "required" : "";
        }

        switch (idTipoIndice) {

            case "1":
            case 1:
                //tipo boolean
                components += "<select name='" + el.identificador + "' id='" + el.identificador + "' data-indice='" + idTipoIndice + "' data-identificador='" + el.identificador + "' class='form-control submitComponent' " + required + " >";                            
                
                $.each(infoInput.selectOptions, function(key, val){
                    components += "<option value=" + key + ">" + val + "</option>"
                });

                components += "</select>";

                break;

            case "12":
            case 12:
                components += "<select name='" + el.identificador + "' id='" + el.identificador + "' data-indice='" + idTipoIndice + "' data-identificador='" + el.identificador + "' class='form-control submitComponent' " + required + " >";
                components += "<option value=''>Selecione</option>"
                $.each(el.listaMultivalorado, function(key, val){
                    components += "<option value=" + val.descricao + ">" + val.descricao + "</option>"
                });
                components += "</select>";

                break;

            case "17":
            case 17:

                infoInput = arrayTipoIndiceGED[el.idTipoIndice];

                components += "<input name='" + el.identificador + "' id='" + el.identificador + "' type='" + infoInput.htmlType + "' data-indice='" + idTipoIndice + "' data-identificador='" + el.identificador + "' class='form-control submitComponent " + infoInput.cssClass + " ' " + required + " />";

                if (infoInput.cssClass) {
                    $("." + infoInput.cssClass).mask(infoInput.mask, {reverse: true});
                }
                
                break;
        
            default:
                components += "<input name='" + el.identificador + "' id='" + el.identificador + "' type='" + infoInput.htmlType + "' data-indice='" + idTipoIndice + "' data-identificador='" + el.identificador + "' class='form-control submitComponent " + infoInput.cssClass + " ' " + required + " />";
                
                if (infoInput.cssClass) {
                    $("." + infoInput.cssClass).mask(infoInput.mask, {reverse: true});
                }

                break;               
        }
        components += "</div>";
    });

    $($_component).append(components);
}
