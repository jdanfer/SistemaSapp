<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informatica;
use App\Models\Paramgral;
use App\Models\Grupoinf;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Correo;
use App\Exports\InformaticasExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

///require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
//7061

class AdminController extends Controller
{
    // Informaticas    

    public function sendCorreo()
    {
        $correocuenta = 'jdanfer@gmail.com';
        $nombre = 'Enrique Robaina';
        Mail::to($correocuenta)->send(new Correo($correocuenta, $nombre));
        return redirect('/');
    }

    //    public function envioCorreo(Request $request)
    //    {
    //        $contactName = $request->name;
    //        $contactEmail = $request->email;
    //        $contactMessage = $request->message;
    //        Mail::to(Auth::user()->email)
    //            ->send(new Contact($contactName, $contactEmail, $contactMessage));
    //        return redirect('/');
    //    }

    public function showInformaticaCreate()
    {
        $informaticas = Informatica::all();
        $grupoinfs = Grupoinf::all();
        return view('/layouts/herramientas/informaticaCreate', [
            'informaticas' => $informaticas,
            'grupoinfs' => $grupoinfs,
        ]);
    }

    public function showInformatica()
    {
        //        $jefaturas = Jefatura::orderBy('descrip', 'asc')->get();
        //$datospreguntas = Pregunta::where('titulo_id', $request->titulo_id)->get();
        $permisos = Permiso::all();
        if (Auth::user()->administra === 1) {
            $informaticas = Informatica::whereNull('fecha_fin')->get();

            return view('/layouts/herramientas/informaticaEdit', [
                'informaticas' => $informaticas,
                'permisos' => $permisos,
            ]);
        } else {
            $informaticas = Informatica::where('user_id', auth()->id())->get();
            return view('/layouts/herramientas/informaticaEdit', [
                'informaticas' => $informaticas,
                'permisos' => $permisos,
            ]);
        }
    }
    public function showInformaticaEdit($id)
    {
        return view("/layouts/herramientas/informatica", [
            "informatica" => Informatica::find($id)
        ]);
    }

    //    public function editJefatura(Request $request, $id)
    //    {
    //        $request->validate(Jefatura::$rules, Jefatura::$customMessages);
    //        $jefatura = Jefatura::find($id);
    //        $jefaturaant = $jefatura->descrip;
    //        $jefatura->descrip = $request->descrip;
    //        $jefatura->save();
    //        return redirect('/admin/evaluadores')->with('mensaje', "El evaluador $jefaturaant fue actualizado exitosamente.");
    //    }

    public function deleteInformatica(Request $request, $id)
    {
        $informatica = Informatica::find($id);
        $descripcion = $informatica->descripcion;
        $informatica = Informatica::find($id)->delete();
        return redirect('/layouts/herramientas/informatica')->with('mensaje', "La solicitud $descripcion fue eliminada exitosamente.");
    }

    public function createInformatica(Request $request)
    {
        $rules = [
            'descripcion' => 'required|min:3',
            'grupoinf_id' => 'required',
        ];
        $customMessages = [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'grupoinf_id.required' => 'El campo Grupo es requerido',
        ];

        $request->validate($rules, $customMessages);
        $userid = auth()->id();
        $fecha = date('Ymd');
        $hora = date('h:i');
        $paramgral = Paramgral::find(2);
        $informatica = new Informatica;
        $informatica->descripcion = $request->descripcion;
        $informatica->base = $paramgral->base;
        $informatica->user_id = $userid;
        $informatica->grupoinf_id = $request->grupoinf_id;
        $informatica->fecha = $fecha;
        $informatica->hora = $hora;
        $informatica->save();
        return redirect('informatica')->with('mensaje', 'Se ha creado correctamente la solicitud Nro: ' . $informatica->id);
    }

    public function showTabla()
    {
        return view('/layouts/navbars/tablasdelSistema');
    }

    public function showPermisoCreate()
    {
        return view('/layouts/admin/permisos');
    }

    public function createPermiso(Request $request)
    {
        $rules = [
            'opcion' => 'required|min:3',
            'username' => 'required',
        ];
        $customMessages = [
            'opcion.required' => 'El campo descripción es obligatorio',
            'opcion.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'username.required' => 'El campo Grupo es requerido',
        ];
        $request->validate($rules, $customMessages);

        $usuarios = User::where('username', $request->username)->first();
        if ($usuarios != null) {
            $permiso = new Permiso;
            $permiso->opcion = $request->opcion;
            $permiso->user_id = $usuarios->id;
            $permiso->menu = 'Sistema SAPP';
            $permiso->save();
            return redirect('permisos/crear')->with('mensaje', 'Se ha agregado correctamente el permiso.');
        } else {
            return redirect('permisos/crear')->with('mensajealerta', 'NO SE PUDO GRABAR! No se encuentra el usuario ingresado.');
        }
    }

    public function printInformaticas(Request $request)
    {
        $rules = [
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
            'filtro' => 'required',
        ];
        $customMessages = [
            'fecha_ini.required'    => 'El campo fecha inicial es obligatorio.',
            'fecha_fin.required'    => 'El campo fecha final es obligatorio.',
            'filtro.required'       => 'El campo filtro es requerido.',
        ];
        $request->validate($rules, $customMessages);

        if (isset($request->filtro)) {
            if ($request->filtro === 'Todo') {
                $informaticas = Informatica::where('fecha', '>=', $request->fecha_ini)
                    ->where('fecha', '<=', $request->fecha_fin)->get();
            } else {
                if ($request->filtro === 'Pendiente') {
                    $informaticas = Informatica::where('fecha', '>=', $request->fecha_ini)
                        ->where('fecha', '<=', $request->fecha_fin)
                        ->whereNull('fecha_fin')->get();
                } else {
                    $informaticas = Informatica::where('fecha_fin', '>=', $request->fecha_ini)
                        ->where('fecha_fin', '<=', $request->fecha_fin)->get();
                }
            }
        } else {
            $informaticas = Informatica::whereNull('fecha_fin')->get();
        }
        if ($informaticas != null) {
        }
        ///        return Excel::download(new InformaticasExport, 'informaticas.xls');
    }

    public function verInformaticas(Request $request)
    {
        $fecha = date('Ymd');
        if (Auth::user()->administra === 1) {
            $informaticas = Informatica::where('fecha', '>=', $fecha)->get();
        } else {
            $informaticas = Informatica::where('fecha', '>=', $fecha)
                ->where('user_id', auth()->id())->get();
        }
        return view("/layouts/herramientas/informaticaPrint", [
            'informaticas' => $informaticas,
        ]);
    }

    public function crearExcel()
    {
        $archivoexcel = new Spreadsheet();
        $archivoexcel->getProperties()->setCreator("Archivo1")->setTitle("Prueba");
        $archivoexcel->setActiveSheetIndex(0);
        $hojaActiva = $archivoexcel->getActiveSheet();
        $archivoexcel->getDefaultStyle()->getFont()->setName('Tahoma');
        $archivoexcel->getDefaultStyle()->getFont()->setSize(15);
        $hojaActiva->getColumnDimension('A')->setWidth(20);

        $hojaActiva->setCellValue('A1', 'CODIGOS');
        $hojaActiva->setCellValue('B2', 232322);
        $hojaActiva->setCellValue('C1', 'Markos FErnad')->setCellValue('D1', 'CDP');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pruebas.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($archivoexcel, 'Xls');
        $writer->save('php://output');

        //        $writer = new Xls($archivoexcel);
        //        $writer->save('Pruebas excel.xls');
    }

    public function crearExcelInformatica()
    {
    }
}
