<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ConsumirServicioController extends Controller
{
    public function RecolectarDatos(Request $request)
    {
        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = "test-" . rand(100000, 999999);
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = "http://localhost:8000/";
            $lcUrlReturn           = "http://localhost:8000/";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $laValues = explode(";", $laResult->values)[1];

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">'. $laResult->values . '</p><br>';
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

    public function ConsultarEstado(Request $request)
    {
        
        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => @$laResult->values
        ];

        for ($i = 0; $i < 5; $i++) {


            $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
                'headers' => $laHeaderEstadoTransaccion,
                'json' => $laBodyEstadoTransaccion
            ]);

            $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());

            echo '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';

            sleep(3);
        }
    }
}
