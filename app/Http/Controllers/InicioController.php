<?php

namespace App\Http\Controllers;

use App\UsuarioModel;
use App\TasaCambioModel;
use Mail;
use SoapClient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\http\Requests;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $nombreUsuario = session('nombreUsuario');
        /** recupera nombre del usuario en session */
        $tipoUsuario = session('tipoUsuario');
        /** recupera el tipo de usuario en session */
        $id_session = session('idUsuario');

        if (!empty($nombreUsuario)) {
            if ($tipoUsuario != 3) {
                /** Consulta si ya existe la tasa de cambio(Dia) guardada */
                $cambio = (new TasaCambioModel)->getTasacambio();

                if (!empty($cambio)) {
                    $tasa_cambio = $cambio[0]->monto;
                } else {

                    /** servicio tASA DE CAMBIO "Banco de Nicaragua" */
                    $context = stream_context_create([
                        'ssl' => [
                            // set some SSL/TLS specific options
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ]);

                    $servicio = "https://servicios.bcn.gob.ni/Tc_Servicio/ServicioTC.asmx?WSDL"; //url del servicio
                    $parametros = ["trace" => 1, "exceptions" => true, "stream_context" => $context];
                    $parametros['Dia'] = date("d");
                    $parametros['Mes'] = date("m");
                    $parametros['Ano'] = date("Y");
                    $client = new SoapClient($servicio, $parametros);
                    $result = $client->RecuperaTC_Dia($parametros); //llamamos al método que nos interesa con los parámetros

                    $tasa_cambio = $result->RecuperaTC_DiaResult; //Capturamos respuesta

                    $cambio_now = (new TasaCambioModel)->setTasacambio($tasa_cambio, $id_session);
                    $tasa_cambio = $cambio_now[0]->monto;
                }

                return view('theme.bracket.layout')->with('nombre', $nombreUsuario)->with('tipo', $tipoUsuario)->with('tasa_cambio', $tasa_cambio);
            } else
                return view('theme.bracket.layout')->with('nombre', $nombreUsuario)->with('tipo', $tipoUsuario);
        } else
            return view('inicio');
    }

    public function login(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $password = $request->password;
        $user = $request->user;
        /** Llama metodo del modelo Usuario */
        $query = (new UsuarioModel)->GetUsuario($password, $user);

        if (!empty($query)) {
            if ($query[0]->confirmado == true) {
                /** iniciamos variables de session con valores recuperados de la consulta */
                if ($query[0]->estado == 1) {
                    session(['idUsuario' => ($query[0]->id_usuario)]);
                    session(['nombreUsuario' => ($query[0]->usuario)]);
                    session(['tipoUsuario' => ($query[0]->tipo)]);
                }
                return response()->json(($query[0]->estado));
            } else
                return response()->json(3);
        } else {
            return response()->json(0);
            /** si es usuario no existe o esta eliminado */
        }
    }

    public function loginOut()
    {
        /** elimina las varibles de session */
        session()->forget('idUsuario');
        session()->forget('nombreUsuario');
        session()->forget('tipoUsuario');

        return redirect('/');
    }

    public function getUsuario()
    {
        $id_usuario = session('idUsuario');
        $query = (new UsuarioModel)->GetDatosUsuario($id_usuario);

        if (isset($query)) {
            return response()->json($query);
        } else {
            return response()->json(0);
            /** si es usuario no existe o esta eliminado */
        }
    }

    /** Funcion que permite guardar un nuevo usuario */
    public function guardarUsuario(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $password = $request->pass;
        $user = $request->usuario;
        $correo = $request->correo;
        $telefono = $request->telefono;
        $iso = $request->iso;
        $codigo_confirmacion = Str::random(24);
        /** Genera un Codigo Ramdom */
        $data['confirmation_code'] = $codigo_confirmacion;
        $data['name'] = $user;
        $correoUnico = (new UsuarioModel)->ValidaCorreoDuplicado($correo, 0);
        $usuarioUnico = (new UsuarioModel)->ValidaUsuarioDuplicado($user);

        if (!$usuarioUnico)
            return response()->json(2);

        if ($correoUnico) {
            $query = (new UsuarioModel)->registrarUsuario($password, $user, $correo, $telefono, $codigo_confirmacion, $iso);

            /**  Inicio funcion para enviar correo  */
            $subject = "Confirmacion de correo";
            /** Asunto del Correo */
            $for = $correo;
            /** correo que recibira el mensaje */

            Mail::send('InicioSesion.mailRegistro', $data, function ($msj) use ($subject, $for) {
                // Correo  y  Nombre que Aparecera
                $msj->from("system@cargologisticsintermodal.com", "LOGISTICA DE CARGA INTERMODAL");
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
        // Validar si esta aun la variable de sesion.
        if (!empty(session('idUsuario')))
            $id_usuario = session('idUsuario');
        else
            $id_usuario = (new UsuarioModel)->GetIdByUser(session('nombreUsuario'));

        $password = $request->pass_new;
        $user = $request->usuario;
        $correo = $request->correo;
        $correo_old = $request->correo_old;
        $telefono = $request->telefono;
        $passwordViejo = $request->pass_now;
        $iso = $request->iso;
        $correoUnico = (new UsuarioModel)->ValidaCorreoDuplicado($correo, $id_usuario);

        if (!(new UsuarioModel)->validarcontrasena($id_usuario, $passwordViejo)) {
            return collect([
                'mensaje' => 'Contraseña actual es incorrecta',
                'error' => true,
            ]);
        }

        if ($correoUnico) {
            $confirmado = false;
            $codigo_confirmacion = Str::random(24);
            /** Genera un Codigo Ramdom */

            if ($correo_old == $correo) {
                $codigo_confirmacion = null;
                $confirmado = true;
            }
            // Actualizamos
            $resultado = (new UsuarioModel)->actualizarUsuario($id_usuario, $password, $user, $correo, $telefono, $id_usuario, $passwordViejo, $codigo_confirmacion, $confirmado, $iso);
            if ($resultado) {

                session()->forget('idUsuario');
                session()->forget('nombreUsuario');
                if ($correo_old != $correo) {
                    $subject = "Confirmacion de correo";
                    /** Asunto del Correo */
                    $for = $correo;
                    /** correo que recibira el mensaje */

                    $data['confirmation_code'] = $codigo_confirmacion;
                    $data['name'] = $user;
                    Mail::send('InicioSesion.mailRegistro', $data, function ($msj) use ($subject, $for) {
                        // Mi correo  y  Nombre que Aparecera
                        $msj->from("system@cargologisticsintermodal.com", "LOGISTICA DE CARGA INTERMODAL");
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
        } else {
            return collect([
                'mensaje' => 'El correo que ingreso ya existe',
                'error' => true,
            ]);
        }
    }

    /** Metodo de verificacion de correo */
    public function verificar($code)
    {

        /** Recupera codigo de confirmacion*/
        $codigo_confirmacion = $code;
        /** Busca el usuario segun el codigo*/
        $query = (new UsuarioModel)->verificarCorreo($codigo_confirmacion);

        if (!empty($query)) {

            $id_usuario = $query[0]->id_usuario;
            $usuario = $query[0]->usuario;

            /** Actualiza el estado de la cuenta a confirmado */
            $query = (new UsuarioModel)->actualizarEstado($id_usuario);

            /** iniciamos variables de session con valores recuperados de la consulta */
            session(['idUsuario' => ($id_usuario)]);
            session(['nombreUsuario' => ($usuario)]);
            session(['tipoUsuario' => (3)]);
        }

        return redirect('/');
    }
}
