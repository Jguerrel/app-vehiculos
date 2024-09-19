<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public  $token = "";
    public  $host = "";
    public  $baseUrl = "";

    public function __construct()
    {
        $this->token = env('VITE_API_TOKEN');
        $this->host = env('VITE_API_HOST');
        $this->baseUrl = env('VITE_API_BASE_URL');
    }

    /**
     * Obtiene los datos de un vehiculo por su numero de chasis
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchVehicle(Request $request): JsonResponse
    {
        $token = env('VITE_API_TOKEN');
        $host = env('VITE_API_HOST');
        $baseUrl = env('VITE_API_BASE_URL');
        $info = env('VITE_API_INFO');
        $endpoint = $host . $baseUrl . $info;

        // uppercase the chassis number
        $chassis = strtoupper($request->chassis_number);

        $resp = Http::withToken($token)
            ->send('POST', $endpoint, ['body' => '{"chasis": "' . $chassis . '"}']);

        return response()->json($resp->json(), $resp->status());
    }

    /**
     * Crea una orden de compra
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createPurchaseOrder(Request $request): JsonResponse
    {
        // send request
        $resp = DB::transaction(function () use ($request) {
            $add = env('VITE_API_CREATE_PURCHASE_ORDER');
            $endpoint = $this->host . $this->baseUrl . $add;

            // data
            $quotation = Quotation::find($request->quotation_id);
            $vehicle = Vehicle::find($request->vehicle_id);
            $order = RepairOrder::find($request->order_id);
            $nameItems = array_map(function ($item) {
                return [
                    "subcategoria" => $item['name']
                ];
            }, $request->items);

            // set data
            $data = [
                "ordencompra" => [
                    "numordenreparacion" => $request->order_id,
                    "numcotizacion" => $request->quotation_id,
                    "numfactura" => $quotation?->invoice_number,
                    "chasis" => $vehicle->chassis_number,
                    "workshopid" => $request->workshop_id,
                    "modelo" => $vehicle?->model?->name,
                    "tipo" => $request->type,
                    "monto" => floatval($quotation?->total),
                    "ordenesreparacionsubnivel1" => $nameItems
                ]
            ];

            // send request
            $resp = Http::withToken($this->token)
                ->send('PUT', $endpoint, ['body' => json_encode($data)]);

            // create or update purchase order
            if ($resp->status() === 200) {
                $type = $request->type === 'Garantia' ? 'order_number_warranty' : 'order_number_expenses';
                $order->purchaseOrder()->updateOrCreate(
                    ['quotation_id' => $request->quotation_id],
                    [
                        'user_id' => $request->user_id,
                        $type => $resp->json()['numordencompra']
                    ]
                );
            }

            return $resp;
        });


        return response()->json($resp->json(), $resp->status());
    }

    /**
     * Obtiene el estado de la orden de compra.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOrderStatus(Request $request): JsonResponse
    {
        $add = env('VITE_API_CONSULT_PURCHASE_ORDER');
        $endpoint = $this->host . $this->baseUrl . $add;
        $vehicle = Vehicle::find($request->vehicle_id);

        // set data
        $data = [
            "chasis" => $vehicle->chassis_number,
            "numordencompra" => $request->numordencompra
        ];

        // send request
        $resp = Http::withToken($this->token)
            ->send('POST', $endpoint, ['body' => json_encode($data)]);

        return response()->json($resp->json(), $resp->status());
    }
}
