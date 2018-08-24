<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use League\Flysystem\Config;
//use Twilio;
use Twilio\Rest\Client;

class TwilioSMSController extends Controller
{
    //

    protected function send_sms_one(Request $request)
    {
        $data = $request->all();
        $to = $data['to'];
        $msg = $data['message'];
        $sid = config("twilio.twi_sid");
        $token = config("twilio.TWI_TQK");
        $client = new Client($sid, $token);

        $message = $client->messages->create(
            '+52'.$to,
            array(
                'from' => config("twilio.TWI_PHO"),
                'body' => $msg,
            )
        );

        //print $message->sid;
        $msg = $message->status;
        return redirect('show_panel_consulta_1');

    }

}