<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
       /** Metodo para retornar vista */
   public function template(Request $request)
   {
      $id_usuario=session('idUsuario');
      $vista= $request->vista;
      if(!empty($id_usuario))
      return response()->view($vista);
      else
      return response(-1);

   }
}
