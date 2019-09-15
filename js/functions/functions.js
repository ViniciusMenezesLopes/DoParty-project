function getFormValues(form)
{
    var inputs  = new Array();
    var retorno;

    console.log(form[0][3]);

    $(form).each(function(){
        if($(this).attr('type') == 'radio'){
            if($(this).prop("checked") == true){
                inputs[$(this).attr('name')] = $(this).val();
            }else{
                inputs[$(this).attr('name')] = '';
            }
        }else if($(this).attr('type') != 'radio'){
            inputs[$(this).attr('name')] = $(this).val();
        }
    });

    retorno = Array.isArray(inputs) == true ? inputs : false;
    return false;
    return retorno;
}

function getNavegador()
{
    let navegadores = '';
    let navegador   = '';

    if (navegadores = navigator.userAgent.toLowerCase().indexOf('op') > -1) {
        navegador = "Opera";
    }else if (navegadores = navigator.userAgent.indexOf('MSIE') > -1) {
        navegador = "IE/Edge";
    }else if (navegadores = navigator.userAgent.indexOf('Firefox') > -1) {
        navegador = "Mozilla Firefox";
    }else if (navegadores = navigator.userAgent.indexOf('Epiphany') > -1) {
        navegador = "Epiphany";
    }else if (navegadores = navigator.userAgent.indexOf('Chrome') > -1) {
        navegador = "Google Chrome";
    }else if (navegadores = navigator.userAgent.indexOf('Safari') > -1) {
        navegador = "Safari";
    }

    return navegador;
}