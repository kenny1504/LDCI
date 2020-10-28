<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
       /** Metodo para retornar vista */
   public function template(Request $request)
   {
      $vista= $request->vista;
      if(empty($nombreUsuario))
      return response()->view($vista);
      else
      return response(-1);

   }
}
