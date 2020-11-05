<?php

namespace App\Http\Controllers;
use App\UsuarioModel;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /** Funcion que recupera todos los usuarios*/
    public function getUsuarios()
    {
        $datos= (new UsuarioModel)->getUsuarios();
        return response()->json($datos);

    }

    /** Metodo para activar o desactivar usuario */
    public function cambiarEstado(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_usuario= $request->id_usuario;
        $estado=$request->estado;
        $id_session = session('idUsuario');

        $datos= (new UsuarioModel)->cambiarEstado(intval($id_session),$id_usuario,$estado);
        return response()->json($datos);

    }

    /** Metodo para guardar o actualizar un usuario */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_usuario= $request->id_usuario;
        if (empty($id_usuario))
            $id_usuario=0;
        $usuario=$request->usuario;
        $correo=$request->correo;
        $correo_old=$request->correo_old;
        $iso=$request->iso;
        $tipo=$request->tipo;
        $telefono=$request->telefono;
        $id_session = session('idUsuario');

        $confirmado=false;
        $codigo_confirmacion=Str::random(24);/** Genera un Codigo Ramdom */
        $correoUnico = (new UsuarioModel)->ValidaCorreoDuplicado($correo, $id_usuario);

        if($correoUnico)
        {
            if ($id_usuario==0) {
                $guardar=(new UsuarioModel)->guardarUsuario($usuario,$telefono,$iso,$correo,$tipo,$id_session,$codigo_confirmacion);

                if (!empty($guardar))
                {
                    $subject ="Confirmacion de correo"; /** Asunto del Correo */
                    $for =$correo;/** correo que recibira el mensaje */

                    $data['confirmation_code']=$codigo_confirmacion;
                    $data['name']=$usuario;
                    Mail::send('InicioSesion.mailRegistro',$data,function($msj) use($subject,$for){
                        // Mi correo  y  Nombre que Aparecera
                        $msj->from("system@cargologisticsintermodal.com","LOGISTICA DE CARGA INTERMODAL");
                        $msj->subject($subject);
                        $msj->to($for);
                    });

                    return collect([
                        'mensaje' => 'Usuario guardado con exito!',
                        'error' => false
                    ]);
                }
                else
                    return collect([
                        'mensaje' => 'Error al guardar usuario',
                        'error' => true,
                    ]);
            }else
            {
                if($correo_old==$correo)
                {
                    $codigo_confirmacion=null;
                    $confirmado=true;
                }
                // Actualizamos
                $resultado = (new UsuarioModel)->modificarUsuario($usuario,$telefono,$iso,$correo,$tipo,$confirmado,$codigo_confirmacion,$id_session,$id_usuario);
                if($resultado){

                    if($correo_old!=$correo)
                    {
                        $subject ="Confirmacion de correo"; /** Asunto del Correo */
                        $for =$correo;/** correo que recibira el mensaje */

                        $data['confirmation_code']=$codigo_confirmacion;
                        $data['name']=$usuario;
                        Mail::send('InicioSesion.mailRegistro',$data,function($msj) use($subject,$for){
                            // Mi correo  y  Nombre que Aparecera
                            $msj->from("system@cargologisticsintermodal.com","LOGISTICA DE CARGA INTERMODAL");
                            $msj->subject($subject);
                            $msj->to($for);
                        });
                    }
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
        }
        else
        {
            return collect([
                'mensaje' => 'El correo que ingreso ya existe',
                'error' => true,
            ]);
        }
    }

}
