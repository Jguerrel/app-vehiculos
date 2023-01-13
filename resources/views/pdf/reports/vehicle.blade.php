@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-success text-white p-2 rounded text-center text-uppercase">
            Vehiculos
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3" colspan="4">

                        </th>
                        <th class="text-center font-bold py-3" colspan="3">
                            Monto Reparación
                        </th>

                    </tr>
                </thead>
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3">
                            Nº chasis
                        </th>
                        <th class="text-center font-bold py-3">
                            Marca
                        </th>
                        <th class="text-center font-bold py-3">
                            Modelo
                        </th>
                        <th class="text-center font-bold py-3">
                            Usuario R.
                        </th>
                        <th class="text-center font-bold py-3">
                            Status
                        </th>
                        <th class="text-center font-bold py-3" style="background-color: #D4F5F1">
                            Muelle
                        </th>
                        <th class="text-center font-bold py-3" style="background-color: #D4F5F1">
                            Garantía
                        </th>
                        <th class="text-center font-bold py-3" style="background-color: #D4F5F1">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $v)
                        <tr>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $v['chassis_number'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v['brand'] ?? '---' }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v['model'] ?? '---' }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v['user']  }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v['status_word'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{  number_format($v['dock'],2,',','.') }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{  number_format($v['warranty'],2,',','.') }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{  number_format($v['total'],2,',','.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
