<?php


class PagoFacilCheckoutClient extends Controller
{
    
    public function inicio(){
        
        return \View::make('PagoFacilCheckout');
    }


    public function Encript(){

        parse_str( $_POST['goFormularioCliente'], $loFormDatos);
		 // campos del formulario del cliente
		 $lcPedidoID=$loFormDatos['PedidoDeVenta'] ;
		 $lcEmail= $loFormDatos['Email'] ;
		 $lnTelefono=$loFormDatos['Celular'] ;
		 $lnMonto=$loFormDatos['Monto'] ; 
		 $lcMoneda=$loFormDatos['MonedaVenta'] ;
		 $lcParametro1="Url callback (Para notificar al comercio que se realizó un pago de su servicio o producto)";
		 $lcParametro2="Url Return (Página de retorno para el cliente final, e.g. Página de confirmación de compra)";

         //  aqui vendra el listado de productos que viene en la compra , 
         //en caso de que no tenga , solo se colocara el producto   a vender 
         //es un arrar de objetos el cual se le aplica un json_encode(Propio de php)
		 $laProduct_Detalle=array( 
            "Serial"=>1,
            "Producto" =>  "PRODUCTO1", 
            "LinkPago" => 0 , 
            'Cantidad'=>  2,
            "Precio"=>  10 ,  
            "Descuento" => 0, 
            "Total"=> 20 
            );
        array_push($laListaProductos , $laProduct_Detalle );
        $laProduct_Detalle=array( 
                    "Serial"=>2,
                    "Producto" =>  "PRODUCTO2", 
                    "LinkPago" => 0 , 
                    'Cantidad'=>  5,
                    "Precio"=>  20,  
                    "Descuento" => 0, 
                    "Total"=> 100 
                    );
        array_push($laListaProductos , $laProduct_Detalle );
        $lcParametro3= json_encode($laListaProductos);

         $lcParametro3="";
         $lcParametro4="11";// este parametro es estatco para este tipo de integracion se debe mantener en 11 nomas
 


          /***
          *  $lcParametros1 =   URL callback del comerciok, este metodo se utiliza para notificar al comercio que el pago fue realizado correctamente, 
                                el comercio debera realizar sus procesos correspondientes al realizar un pago.

             $lcParametros2 =   URL de retorno, esta ruta es netamente web, y sera la URL de redireccion del comercio, hacia donde se redirigira
                                al cliente luego de terminar el pago.
          */
        
          
        
		// aqui estoy guardando lo mismo pero para crear la firma
		$tcCommerceID ="dato brindado por PagoFacil Bolivia";
        $lcTokenServicio="dato brindado por PagoFacil Bolivia";
        $lcTokenSecret="dato brindado por PagoFacil Bolivia";
        
        try {
            
            $lcCadenaAFirmar= "$lcTokenServicio|$lcEmail|$lnTelefono|$lcPedidoID|$lnMonto|$lcMoneda|$lcParametro1|$lcParametro2|$lcParametro3|$lcParametro4" ;
		 
            // aqui se genera la firma  con la variable $lcCadenaAFirmar
            $lcFirma= hash('sha256', $lcCadenaAFirmar);
    
            // aqui  se concatena de nuevo pero utilizando la firma al comienzo 
            $lcDatosPago="$lcFirma|$lcEmail|$lnTelefono|$lcPedidoID|$lnMonto|$lcMoneda|$lcParametro1|$lcParametro2|$lcParametro3|$lcParametro4" ;
            
            //Esto es el proceso de encriptacion que ocupa php 
            $lnSizeDatosPago=strlen($lcDatosPago);

            $lcDatosPago=str_pad($lcDatosPago,($lnSizeDatosPago+8-($lnSizeDatosPago%8)), "\0");
            //aqui se genera y se guarda  la variable tcparametros, resultado de la encriptacion de los datos con 3DES

            $tcParametros =   openssl_encrypt($lcDatosPago, "DES-EDE3", $lcTokenSecret ,OPENSSL_ZERO_PADDING);

            $laData['tcParametros']= base64_encode($tcParametros);
            $laData['tcCommerceID']=$tcCommerceID;
            
            
            //este codigo solo sirve para verificar si lo que estan encriptando esta bien 
            $tcParametrosDesencriptado= openssl_decrypt($tcParametros, 'DES-EDE3', $lcTokenSecret,  OPENSSL_ZERO_PADDING);
            $laData['tcParametrosDesencriptado']= $tcParametrosDesencriptado;
            ////////////////////////////////////////////////////////////////////////////
                
            return response()->json($laData);
        } catch (\Throwable $th) {
            return null;
        }
    }
}
