<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebhookMPController extends Controller
{
    public function handlenotification(Request $request)
    {
        $accessToken = env('MP_token');

        try {
            $eventType = $request->input('type');
            $eventId = $request->input('data.id');


            Log::info('Webhook Payload: ' . json_encode($request->all()));
            $client = new Client([
                'base_uri' => 'https://api.mercadopago.com/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            switch ($eventType) {
                case "payment":
                    try {
                        // Obtener información del pago desde la API
                        $response = $client->get("payments/$eventId");
                        $payment = json_decode($response->getBody(), true);
                        $externalReference = $payment['external_reference'];
                        Log::info('External reference: ' . $externalReference);
                        // Verificar si el pago existe
                        if ($payment) {

                            $pay = Payment::where('id_payment', $externalReference)->first();

                            // Verificar si el pago existe y está pendiente
                            if ($pay && $pay->status === 'pending') {
                                // Actualizar el estado del pago
                                $pay->status = 'approved';
                                $pay->save();

                                // Obtener información de la suscripción asociada al pago

                                $sub = Subscription::find($pay->subscription);

                                // Verificar si la suscripción existe
                                if ($sub) {
                                    // Obtener el usuario asociado al pago
                                    $user = User::find($pay->user_id);

                                    // Verificar si el usuario existe
                                    if ($user) {
                                        // Actualizar la validez y la suscripción del usuario
                                        $user->validity_date = Carbon::now()->addDays($sub->validate);
                                        $user->subscription_id = $pay->subscription;
                                        $user->save();


                                        //$porcentaje = ($sub->price * $sub->reference_payment_percentage) / 100;
                                        //  $resultadoFormateado = number_format($porcentaje, 2, '.', '');
                                        // $resultado = $sub->price * ($sub->reference_payment_percentage / 100);

                                        $porcentaje = $sub->reference_payment_percentage;
                                        $valor = $sub->price;

                                        // Calcular el porcentaje
                                        $resultado = $valor * ($porcentaje / 100);

                                        //$resultado = 33.33 * (13 / 100);
                                        $resultadoTruncado = number_format((float)$resultado, 2, '.', '');

                                        $wallet = Wallet::where('user_id', $user->reference)->first();
                                        $new_res = $wallet->total_amount + $resultadoTruncado;
                                        $wallet->total_amount = $new_res;
                                        $wallet->save();

                                        Log::info('Payment processed successfully.');
                                    } else {
                                        Log::error('User not found for payment ID: ' . $eventId);
                                    }
                                } else {
                                    Log::error('Subscription not found for payment ID: ' . $eventId);
                                }
                            } else {
                                Log::info('Payment already processed or not found: ' . $eventId);
                            }
                        } else {
                            Log::error('Payment information not retrieved for ID: ' . $eventId);
                        }
                    } catch (\Exception $e) {
                        Log::error('Error processing payment: ' . $e->getMessage());
                    }
                    break;
                case "plan":
                    $response = $client->get("plans/$eventId");
                    $plan = json_decode($response->getBody(), true);
                    Log::info('Plan processed successfully.');
                    break;
                case "subscription":
                    $response = $client->get("subscriptions/$eventId");
                    $subscription = json_decode($response->getBody(), true);
                    Log::info('Subscription processed successfully.');
                    break;
                case "invoice":
                    $response = $client->get("invoices/$eventId");
                    $invoice = json_decode($response->getBody(), true);
                    Log::info('Invoice processed successfully.');
                    break;
                case "point_integration_wh":
                    // $_POST contém as informações relacionadas à notificação.
                    Log::info('Point Integration Webhook received.');
                    break;
                default:
                    Log::info('Unknown event type.');
            }
        } catch (\Exception $e) {
            Log::error('Error processing webhook: ' . $e->getMessage());
        }

        return response()->json(['status' => 'success']);
        //    return response()->json(["data" => Auth::user()]);
    }
}
