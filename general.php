<?

//$trans=new generales;



class conexion
{

// enlace
var $link;


//Variables para consulta
var $consulta;
var $resultado;
var $cuantos;
var $cantidad;

//variables para insercion
var $inserto;
var $insercion;

//variables para insercion
var $elimino=false;
  


   function conexion()
     
     {
	 
	    // $this->get_datos_acceso_mysql();
       if (!($this->link = mysql_connect("localhost","root","")))
           {
              echo "Error al conectarse con el servidor";
              exit();
           }
        if (!mysql_select_db("roles",$this->link))
           {
              echo "Error al Abrir la Base de Datos";
              exit();
           }
        
     }



 function conectarse_otra($host,$bd,$u,$pass)
     {
       if (!($this->link = mysql_connect("$host","$u","$pass")))
           {
              echo "Error al conectarse con el servidor gggggggg";
              exit();
           }
        if (!mysql_select_db("$bd",$this->link))
           {
              echo "Error al Abrir la Base de Datos";
              exit();
           }
        
     }



   function getInsercion()
   {
      return $this->insercion;
   }

    function consultarBD($sentenciaSQL)
    {
	  
        $this->consulta=mysql_query($sentenciaSQL,$this->link);
     // $this->cantidad=mysql_num_rows($sentenciaSQL,$this->link));
    }



    function obtenerResultado()
     {
       $this->resultado=mysql_fetch_array($this->consulta);
       return $this->resultado;
	   
    }
	
	function Liberar_Resultado()
     {
        mysql_free_result($this->resultado);
       
    } 
	
	function Liberar_Externo($r)
     {
       mysql_free_result($r);
       
    }
	
	
    function obtenerCuantos()
     {
        $this->cuantos=mysql_num_rows($this->consulta);
        return $this->cuantos;
    }
   
function obtenerResultado2()
     {
       $this->resultado=mysql_fetch_row($this->consulta);
       return $this->resultado;
    }

  function obtenerResultadoNum()
     {
      
       return $this->cantidad;
    }
	
	
	  function obtenerResultadoIndice($i)
      {
          //echo $i;
		  $this->result=mysql_result($this->consulta,$i);
         return $this->result;
      }


//funciones para insertar
      function insertarBD($sentenciaSQL)
       {
	   
          if(!($this->inserto=mysql_query($sentenciaSQL,$this->link)))
           {
                 echo "no inserta";
                 $this->insercion=0;
                 
	   		  }
			  else
    		  {
                $this->insercion=1;
			  }
      }
	  
	  
	  
	  
	  
	 /* function ejecutarVariasBD($Asql)
       {
	   
	      mysql_query("BEGIN");

          if(!($this->inserto=mysql_query($sentenciaSQL,$this->link)))
           {
                 echo "no inserta";
                 $this->insercion=0;
                 
	   		  }
			  else
    		  {
                $this->insercion=1;
			  }
      }// fin ejecutarVariasBD
	  
	  */
	  
	   function setAUTOCOMMIT()
	  {
	      try{
		     if(!mysql_query("SET AUTOCOMMIT=0",$this->link)) throw new Exception("No SE seteo el valor AUTOCOMIT A CERO");
		  }catch(Exception $ex){
		   $error= ($eX->getMessage());
             echo "Error generado por mimismo",$error,"<br>";
		  }
		   	 
	  } // fin function 
	  
	  
	  
	  function initTransaccion()
	  {    try{
		     if(!mysql_query("START TRANSACTION",$this->link)) throw new Exception("Error en START TRANSACCION");
		  }catch(Exception $ex){
		   $error= ($ex->getMessage());
             echo "Error generado por mimismo",$error,"<br>";
		  }
		   	 
	  } // fin function
	 
	  
	  function insertarOfertaCarrerasSQL($sql,$Acarreras)
       {
	       $ejecuta=1;
		   $this->setAUTOCOMMIT();
		   $this->initTransaccion();
		   try{
		   					// PRIMERA INSERCION
								
								if(!mysql_query($sql,$this->link)) throw new Exception("Error al insertar en tabla Oferta");
					//obtener codigo generado
								$cod_oferta_insertado=mysql_insert_id();
								echo $cod_oferta_insertado;
					//SEGUNDA INSERCION
								foreach($Acarreras as $carrera) 
								{
								
								   
								   $miQuery="INSERT INTO `poyso`.`oferta_carrera` (
											`cod_oferta` ,
											` cod_carrera` 
											)
											VALUES (
											'$cod_oferta_insertado', '$carrera'
											)";
								   
								   
								   if(!mysql_query($miQuery,$this->link)) throw new Exception("Error al insertar en tabla Oferta_Carrera");
						        }   
								mysql_query("COMMIT",$this->link);
					
								
			    }catch(Exception $exc){
				        mysql_query("ROLLBACK",$this->link);
						$mensaje=($exc->getMessage());
                        echo $mensaje;
						$ejecuta=0;
				        //echo "No ingreso correctamente la OFERTA";
				    
				}
				
				return $ejecuta;
				
			
			 
      }// fin function 
	  
	  
	  
	  function getMaxId()
	  {
	   
	  }

	   

     /* function obtenerIN()
       {
          if(mysql_affected_rows($this->link))
           {
               $this->insercion=true;
            // return $this->insercion;
           } else{ $this->insercion=false;} //return $this->insercion;
       }*/

// FUNCIONES PARA ELIMINAR

      function eliminarBD($sentenciaSQL)
       {
         if(mysql_query($sentenciaSQL,$this->link))
		  return true;
		  else return false;
       }

function actualizarBD($sentenciaSQL)
{
   
   // echo "<br>sql ",$sentenciaSQL,"<br>";
    $actualizo=false;
    if(mysql_query($sentenciaSQL,$this->link))
    {
	   //echo "se actualizo";
       $actualizo=true;
    }
	else echo "no se actualizo";
   return $actualizo;
}

function desconectarBD()
{
 mysql_close($this->link);
}



}// fin class generales

?>