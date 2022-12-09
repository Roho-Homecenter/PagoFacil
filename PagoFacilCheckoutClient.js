 

function PrepararParametros()
{
    // se manda los datos del FormCliente ara que realize la encriptacion y devuelva
    //los datos para el FormPagoFacil
    // aqui se obtiene todo el Formulario del cliente en la variable loFormularioCliente
    var goFormularioCliente=$("#FormCliente").serialize();
    // esta es la url que se mandaran los 
    var lcUrlajax="PagoFacilCheckoutEncript";   

    ////////esta parte es aplicado solo para proyecto hechos en laravel 
    //ya que pide u token para pode r llamar a una ruta 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
    //----------
    $.ajax({                  
            url: lcUrlajax,
            data: {goFormularioCliente},
            type : 'POST',
            dataType: "json",
            beforeSend:function( ) {   
                
                //console.log(goFormularioCliente);  
            },                    
            success:function(response) {

                //console.log(goFormularioCliente);  
                console.log("Exito");
                console.log(response);

                $("#tcParametros").val(response.tcParametros);
                $("#tcCommerceID").val(response.tcCommerceID);
                $("#btnpagar").click();
            



            },
            error: function (data) {
                console.log("Error");
                console.log(data.responseText);
                
            },               
            complete:function( ) {
                    
            },
        }
        ); 
}
 