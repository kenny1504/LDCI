<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
       /** Metodo para retornar vista */
   public function template(Request $request)
   {
      $vista= $request->vista;
      return response()->view($vista);
   }
}
