<?php

namespace App\Http\Controllers;

use App\Mail\Certificado;
use App\Models\Certificate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PruebasController extends Controller
{
    public function prueba()
    {
        $today = Carbon::now('America/Argentina/Buenos_Aires')->format('Y-m-d');
        $certificados = Certificate::whereDate('created_at',$today)->get();

        foreach ($certificados as $certificado) {
            $email = $certificado->student->email;
            $name = $certificado->student->last_name . ' ' . $certificado->student->name;
            $correo = new Certificado($name);
            Mail::to($email)->send($correo);
        }
    }
}
