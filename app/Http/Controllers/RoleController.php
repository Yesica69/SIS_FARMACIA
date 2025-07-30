<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get(); // importante
        $permisos = Permission::all();
    
        return view('admin.roles.index', compact('roles', 'permisos'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            
            'name'=>'required|unique:roles',
            
        ]);
        //
        $rol =new Role();
        $rol->name = $request->name;
        $rol->guard_name = "web";
        $rol->save();


        return redirect()->route('admin.roles.index')
        ->with('mensaje','Se registro el rol')
        ->with('icono','success');

        

            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
{
    $role = Role::findOrFail($id);
    return view('admin.roles.edit', compact('role'));
    
}

public function update(Request $request, string $id)


{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $id,
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->name;
    $role->save();

    return redirect()->route('admin.roles.index')
        ->with('mensaje', 'Rol actualizado con éxito')
        
        ->with('icono', 'success');
}



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->route('admin.roles.index')
        ->with('mensaje', 'Rol eliminado con éxito')
        ->with('icono', 'success');
}
public function reporte() {
    return view('admin.roles.reporte'); // Solo carga la vista, sin generar PDF
}

public function asignar($id){
    $rol = Role::find($id);
    $permisos = Permission::all();
    return view('admin.roles.index', compact('permisos', 'rol'));
}

public function update_asignar(Request $request, $id){
   // $datos = request()->all();
    //return response()->json($datos);


  
    // Encuentra el rol
    $rol = Role::find($id);

    $rol->permissions()->sync($request->input('permisos'));

    return redirect()->back()
        ->with('mensaje', 'Se asigno el permiso')
        
        ->with('icono', 'success');
}
public function generarReporte(Request $request)
{
    $request->validate([
        'tipo' => 'required|in:pdf,excel,csv,print'
    ]);
    
    $tipo = $request->tipo;
    $roles = Role::with(['permissions', 'users'])->get();

    switch ($tipo) {
        case 'pdf':
            return $this->generarPDF($roles);
        case 'excel':
            return $this->generarExcel($roles);
        case 'csv':
            return $this->generarCSV($roles);
        case 'print':
            return view('admin.roles.reporte', [
                'roles' => $roles,
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ]);
        default:
            abort(404, 'Tipo de reporte no válido');
    }
}
 protected function generarReportePorTipo($tipo, $sucursals)
    {
        switch ($tipo) {
            case 'pdf':
                return $this->generarPDF($sucursals);
            case 'excel':
                return $this->generarExcel($sucursals);
            case 'csv':
                return $this->generarCSV($sucursals);
            case 'print':
                return view('admin.sucursals.reporte', [
                    'sucursals' => $sucursals,
                    'fecha_generacion' => now()->format('d/m/Y H:i:s')
                ]);
            default:
                abort(404);
        }
    }
    private function generarPDF($roles)
    {
        $pdf = Pdf::loadView('admin.roles.reporte', [
            'roles' => $roles,
            'fecha_generacion' => now()->format('d/m/Y H:i:s')
        ]);
        
        return $pdf->download('reporte_roles_'.now()->format('YmdHis').'.pdf');
    }
private function generarExcel($roles)
{
    $data = $roles->map(function ($role) {
        return [
            'ID' => $role->id,
            'Nombre del Rol' => $role->name,
            'N° Usuarios' => $role->users_count ?? $role->users->count(),
            'Permisos Asignados' => $role->permissions->pluck('name')->implode(', ') ?: 'Sin permisos',
            'Fecha Creación' => $role->created_at->format('d/m/Y H:i'),
            'Última Actualización' => $role->updated_at->format('d/m/Y H:i')
            
        ];
    });

    return Excel::download(
        new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection,
                               \Maatwebsite\Excel\Concerns\WithHeadings,
                               \Maatwebsite\Excel\Concerns\WithStyles,
                               \Maatwebsite\Excel\Concerns\ShouldAutoSize,
                               \Maatwebsite\Excel\Concerns\WithColumnWidths,
                               \Maatwebsite\Excel\Concerns\WithEvents {
            
            private $data;
            
            public function __construct($data) {
                $this->data = collect($data);
            }
            
            public function collection() {
                return $this->data;
            }
            
            public function headings(): array {
                return [
                    'ID',
                    'Nombre del Rol',
                    'N° Usuarios',
                    'Permisos Asignados',
                    'Fecha Creación',
                    'Última Actualización'
                    
                ];
            }
            
            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet) {
                return [
                    // Estilo encabezados
                    1 => [
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb' => 'FFFFFF'],
                            'size' => 12
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '3498DB'] // Azul
                        ],
                        'alignment' => [
                            'horizontal' => 'center',
                            'vertical' => 'center'
                        ]
                    ],
                    // Estilo cuerpo
                    'A2:G' . $sheet->getHighestRow() => [
                        'alignment' => [
                            'vertical' => 'center',
                            'wrapText' => true
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => 'EEEEEE']
                            ]
                        ]
                    ],
                    // Alineación izquierda para nombres
                    'B2:B' . $sheet->getHighestRow() => [
                        'alignment' => [
                            'horizontal' => 'left'
                        ]
                    ],
                    
                ];
            }
            
            public function columnWidths(): array {
                return [
                    'A' => 8,   // ID
                    'B' => 25,  // Nombre
                    'C' => 12,  // N° Usuarios
                    'D' => 40,  // Permisos
                    'E' => 18,  // Fecha Creación
                    'F' => 18 // Actualización
                 
                ];
            }
            
            public function registerEvents(): array {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        // Congelar la primera fila (encabezados)
                        $event->sheet->freezePane('A2');
                        
                        // Auto-filtro para encabezados
                        $event->sheet->setAutoFilter(
                            $event->sheet->calculateWorksheetDimension()
                        );
                    }
                ];
            }
        },
        'reporte_roles_' . now()->format('YmdHis') . '.xlsx'
    );
}
    private function generarCSV($roles)
    {
        return Excel::download(
            new RolesExport($roles),
            'reporte_roles_'.now()->format('YmdHis').'.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

}

