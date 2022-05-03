<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            border: 0;
            line-height: 1.5rem;
        }
        .border-dashed{
            border: dashed 1px grey;
        }
        .float-right{
            float: right;
        }
        .float-left{
            float: left;
        }
        .font-bold{
            font-weight: 700;
        }
        .mt-7{
            margin-top: 1.75rem;
        }
        .mt-40{
            margin-top: 10rem;
        }
        .pt-3{
            padding-top: 0.75rem;
        }
        .p-5{
            padding: 1.25rem;
        }
        .pb-5{
            padding-bottom: 1.25rem;
        }
        .px-7{
            padding-left: 1.75rem;
            padding-right: 1.75rem;
        }
        .text-lg{
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        .text-base{
            font-size: 1rem;
            line-height: 1.5rem;
        }
        .text-sm{
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        .text-xs{
            font-size: 0.75rem;
            line-height: 1rem;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .uppercase{
            text-transform: uppercase;
        }
        .w-33{
            width: 33.3333%
        }
        .w-50{
            width: 50%;
        }
        .w-100{
            width: 100%;
        }
    </style>
</head>
<body class="p-5">
    <div class="px-7 pb-5 pt-3 border-dashed">
        <div class="text-center">
            <p class="text-lg font-bold">ESCUELA DE CAPACITACIÓN</p>
            <p class="text-lg">Sede {{ $sucursal->branch_name }} ({{$sucursal->academy->name}})</p>
        </div>
        <div class="text-right font-bold mt-7">
            <p>CERTIFICADO N° {{$certificado->id}}</p>
        </div>
        <div class="mt-7">
            <table class="w-100 uppercase">
                <tbody>
                    <tr>
                        <td class="w-50">
                            <p>Nombre: <span class="font-bold">{{$alumno->last_name . ' ' . $alumno->name}}</span></p>
                            <p class="text-sm">Fecha de nacimiento: <span class="font-bold">{{$alumno->birth_date}}</span></p>
                            <p class="text-sm">N° doc: <span class="font-bold">{{$alumno->dni}}</span></p>
                        </td>
                        <td class="text-right w-50">
                            <p>Curso: <span class="font-bold">{{$curso->courseType->course_type_name}}</span></p>
                            <p class="text-sm">Horas teóricas: <span class="font-bold">{{ \Carbon\Carbon::parse($curso->total_hours)->format('H:i') }} horas</span></p>
                            <p class="text-sm">Fecha de inicio: <span class="font-bold">{{ $dias->first()->get_date }}</span></p>
                            <p class="text-sm">Fecha de Finalización: <span class="font-bold">{{ $dias->last()->get_date }}</span></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-7 font-bold text-center">
            <p>EL PRESENTE CERTIFICADO NO HABILITA A CONDUCIR.</p>
            <p>DEBERÁ SER PRESENTADO EN D.G.LIC.</p>
        </div>
        <div class="mt-7 font-bold">
            <p>Este certificado es válido hasta el: {{ $vencimiento }}</p>
        </div>
        <div class="mt-7 text-right">
            <p class="font-bold">
                Sede {{ $sucursal->branch_name }} ({{$sucursal->academy->name}}) - {{$sucursal->street . ' ' . $sucursal->streetHeight}} - 
            </p>
            <p class="text-sm">
                Impreso por {{ $operador->last_name . ' ' . $operador->name  }} / en nombre de {{ $operador->academy ? $operador->academy->name : '' }}
            </p>
        </div>
        <div class="mt-40">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="text-xs">{{ $hoy }}</td>
                        <td class="text-center"><img src="{{ $logo }}" width="150px"></td>
                        <td class="font-bold uppercase text-xs">Firma habilitante academia</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>