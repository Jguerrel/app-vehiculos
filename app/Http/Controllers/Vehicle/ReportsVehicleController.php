<?php

namespace App\Http\Controllers\Vehicle;

use Inertia\Inertia;
use App\DB\VehicleDB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Enum\{StatusRepairOrderEnum, RoleEnum};
use App\Exports\VehicleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response as HttpResponse;
use App\Factories\{ModelVehicleFactory, BrandFactory, ColorFactory, UserFactory};

class ReportsVehicleController extends Controller
{
    public function __construct(
        private ModelVehicleFactory $modelVehicleF,
        private BrandFactory $brandF,
        private ColorFactory $colorF,
        private VehicleDB $dbVehicle,
        private UserFactory $userF
    ) {}

    /**
     * Devuelve la vista principal de reportes
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Reports/Vehicle/Index', [
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter(),
            'models' => [],
            'users' => $this->userF->getUsersWithRol(RoleEnum::RECORDER),
            'brands' => $this->brandF->getBrands(),
            'status' => StatusRepairOrderEnum::getNames(),
            'filters' => [
                'brand' => null,
                'model' => null,
                'dates' => null,
                'nro_chasis' => null,
                'user_id' => null,
                'status' => null
            ],
        ]);
    }

    /**
     * Query para el reporte
     * ir cambiando la data de la vista
     *
     * @return void
     */
    public function queryReports()
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;
        $user_id = request()->user_id;
        $status = request()->status;

        return Inertia::render('Reports/Vehicle/Index', [
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter($brand, $model, $dates, $nro_chasis, $user_id, $status),
            'models' => $this->modelVehicleF->getModelsByBrand($brand),
            'brands' => $this->brandF->getBrands(),
            'users' => $this->userF->getUsersWithRol(RoleEnum::RECORDER),
            'status' => StatusRepairOrderEnum::getNames(),
            'filters' => [
                'brand' => $brand,
                'model' => $model,
                'dates' => $dates,
                'nro_chasis' => $nro_chasis,
                'user_id' => $user_id,
                'status' => $status
            ],
        ]);
    }

    /**
     * Ver modelos por marca
     *
     * @return void
     */
    public function modelsByBrands()
    {
        $brand_id = request()->brand_id;
        return $this->modelVehicleF->getModelsByBrand($brand_id);
    }

    /**
     * Reporte PDF General
     *
     * @return HttpResponse
     */
    public function downloadPDF(): HttpResponse
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;
        $user_id = request()->user_id;
        $status = request()->status;

        $data = $this->dbVehicle->getVehiclesReportsFilter($brand, $model, $dates, $nro_chasis, $user_id, $status);
        $pdf = Pdf::loadView('pdf.reports.vehicle', ['vehicles' => $data, 'dates' => $dates])->setPaper('a4', 'landscape');
        $name = 'reports-vehiculos-' . date('YmdHis') . '.pdf';
        return $pdf->stream($name);
    }

    /**
     * Reporte excel general
     *
     * @return void
     */
    public function downloadEXCEL()
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;
        $user_id = request()->user_id;
        $status = request()->status;

        $data = $this->dbVehicle->getVehiclesReportsFilter(
            $brand,
            $model,
            $dates,
            $user_id,
            $nro_chasis,
            $status
        );

        $fullName = 'reporte-vehiculos ' . date('Y-m-d-H-i-a') . '.xlsx';
        return Excel::download(new VehicleReportExport($data), $fullName);
    }

    /**
     * Reporte PDF individual
     *
     * @param Int $id
     * @return void
     */
    public function printPDFVehicleByID($id)
    {
        $vehicle = $this->dbVehicle->getVehicleReportById($id);
        $pdf = Pdf::loadView('pdf.vehicle.pdf', compact('vehicle'));
        $date = date('Y-m-d-H-i-s');
        return $pdf->stream('reporte-vehiculo-' . $date . '.pdf');
    }
}
