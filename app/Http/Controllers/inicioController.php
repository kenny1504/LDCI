<?php

namespace App\Http\Controllers;
use App\usuarioModel;
use Mail;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\http\Requests;

class inicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $nombreUsuario = session('nombreUsuario'); /** recupera nombre del usuario en session */
          if(!empty($nombreUsuario))
          return view('theme.bracket.layout')->with('nombre', $nombreUsuario);
         else
           return view('inicio');
    }

    public function inicio()
    {
       $nombreUsuario = session('nombreUsuario'); /** recupera nombre del usuario en session */
      /** revuelve vista y nombre del usuario logueado */

      if(!empty($nombreUsuario))
       return view('theme.bracket.layout')->with('nombre', $nombreUsuario);
      else
        return view('inicio');
    }
    
    public function login(Request $request)
    {

        /** Recupera parametros enviados por ajax */
       $password= $request->password;
       $user= $request->user;
       /** Llama metodo del modelo Usuario */
        $query = (new usuarioModel)->GetUsuario($password,$user);
        if(!empty($query))
         {
            if($query[0]->confirmado==true)
            {
               /** iniciamos variables de session con valores recuperados de la consulta */
               session(['idUsuario' =>($query[0]->id_usuario) ]);
               session(['nombreUsuario' =>($query[0]->usuario) ]);
               return response()->json(($query[0]->estado));
            }
            else
               return response()->json(3);
         }else
         {
            return response()->json(0); /** si es usuario no existe o esta eliminado */
         } 
         

    }

    public function loginOut()
    {
         /** elimina las varibles de session */
        session()->forget('idUsuario');
        session()->forget('nombreUsuario');

        return view('inicio');

    }

    public function getUsuario()
    {
        $id_usuario=session('idUsuario');
        $query = (new usuarioModel)->GetDatosUsuario($id_usuario);

        if(isset($query))
         {
            return response()->json($query);
         }else
         {
            return response()->json(0); /** si es usuario no existe o esta eliminado */
         } 

    }

    public function registro()
    {
      return view('InicioSesion/registro');
    }


    /** Funcion que permite guardar un nuevo usuario */
    public function guardarUsuario(Request $request)
    {

      /** Recupera parametros enviados por ajax */
      $password= $request->pass;
      $user= $request->usuario;
      $correo= $request->correo;
      $telefono= $request->telefono;
      $codigo_confirmacion=Str::random(24);/** Genera un Codigo Ramdom */
      $data['confirmation_code']=$codigo_confirmacion;
      $data['name']=$user;
      $correoUnico = (new usuarioModel)->ValidaCorreoDuplicado($correo, 0);
      $usuarioUnico = (new usuarioModel)-> ValidaUsuarioDuplicado($user);

      if(!$usuarioUnico)
      return response()->json(2);

      if($correoUnico)
      {
         $query = (new usuarioModel)->registrarUsuario($password,$user,$correo,$telefono,$codigo_confirmacion);

         /**  Inicio funcion para enviar correo  */
         $subject ="Confirmacion de correo"; /** Asunto del Correo */
         $for =$correo;/** correo que recibira el mensaje */

         
         Mail::send('InicioSesion\mailRegistro',$data,function($msj) use($subject,$for){
                                 // Mi correo  y  Nombre que Aparecera 
                  $msj->from("guisselalemanbonilla@gmail.com","LOGISTICA DE CARGA INTERMODAL"); 
                  $msj->subject($subject);
                  $msj->to($for);
         }); 
         
         /** Fin funcion para enviar correo */

         return response()->json(1);
      }
      return response()->json(0);
    }

    public function editarUsuario(Request $request)
    {
      $id_usuario = 0;
      // Validar si esta aun la variable de sesion.
      if(session('idUsuario') === null)
         $id_usuario = session('idUsuario');     
      else
         $id_usuario = (new usuarioModel)->GetIdByUser(session('nombreUsuario'));
      
      $password= $request->password;
      $user= $request->usuario;
      $correo= $request->correo;
      $telefono= $request->telefono;
      $passwordActual= $request->pass_now;
      $correoUnico = (new usuarioModel)->ValidaCorreoDuplicado($correo, $id_usuario);
      
      if(!(new usuarioModel)->validarcontrasena($id_usuario, $passwordActual)){
         return collect([
            'mensaje' => 'La Contraseña actual es diferente a la ingresada',
            'error' => true,
        ]);
      }    

      if($correoUnico)
      {
         $codigo_confirmacion=Str::random(24);/** Genera un Codigo Ramdom */
         // Actualizamos
         $resultado = (new usuarioModel)->actualizarUsuario($id_usuario, $password,$user,$correo,$telefono,now(),$id_usuario, $passwordViejo, $codigo_confirmacion);
         if($resultado){
             
                     session()->forget('idUsuario');
                     session()->forget('nombreUsuario');
                     $subject ="Confirmacion de correo"; /** Asunto del Correo */
                     $for =$correo;/** correo que recibira el mensaje */

                     
                     $data['confirmation_code']=$codigo_confirmacion;
                     $data['name']=$user;
                     Mail::send('InicioSesion\mailRegistro',$data,function($msj) use($subject,$for){
                                             // Mi correo  y  Nombre que Aparecera 
                              $msj->from("kennysaenz31@gmail.com","LOGISTICA DE CARGA INTERMODAL"); 
                              $msj->subject($subject);
                              $msj->to($for);
                     }); 
                     
                     return collect([
                        'mensaje' => 'Información actualizada',
                        'error' => false
                     ]);

            }
         return collect([
            'mensaje' => 'Error al actualizar',
            'error' => true,
        ]);
      }
      else
      {
         return collect([
            'mensaje' => 'Correo duplicado',
            'error' => true,
        ]);
      }
    }

    /** Metodo de verificacion de correo */
    public function verificar($code)
   {
      
        /** Recupera codigo de confirmacion*/
        $codigo_confirmacion= $code;
        /** Busca el usuario segun el codigo*/
         $query = (new usuarioModel)->verificarCorreo($codigo_confirmacion);
 
         if(!empty($query))
          {

            $id_usuario=$query[0]->id_usuario;
            $usuario=$query[0]->usuario;

            /** Actualiza el estado de la cuenta a confirmado */
             $query = (new usuarioModel)->actualizarEstado($id_usuario);

             /** iniciamos variables de session con valores recuperados de la consulta */
             session(['idUsuario' =>($id_usuario) ]);
             session(['nombreUsuario' =>($usuario) ]);

             return view('theme.bracket.layout')->with('nombre', $usuario);
          }
          else
                return view('inicio');
          
   }


}