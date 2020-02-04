<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;

class TwilioChatController extends Controller
{
    private $twilio_account_sid;
    private $twilio_api_key;
    private $twilio_api_secret;
    private $service_sid;
    private $identity;

    public function __construct()
    {
      $this->twilio_account_sid = config('services.twilio')['sid'];
      $this->twilio_api_key = config('services.twilio')['key'];
      $this->twilio_api_secret = config('services.twilio')['secret'];
      $this->service_sid = config('services.twilio')['grant'];
      $this->identity = '';
    }

    public function getToken(Request $request)
    {
      $this->identity = $request->identity;
      // Create access token, which we will serialize and send to the client
      $token = new AccessToken(
        $this->twilio_account_sid,
        $this->twilio_api_key,
        $this->twilio_api_secret,
        3600,
        $this->identity
      );

      // Create Chat grant
      $chat_grant = new ChatGrant();
      $chat_grant->setServiceSid($this->service_sid);

      // Add grant to token
      $token->addGrant($chat_grant);

      // render token to string
      echo $token->toJWT();
    }

    public function deleteChannel()
    {
      $twilio = new Client($this->twilio_account_sid, env('TWILIO_TOKEN'));

      $twilio->chat->v2->services("IS6122135e5f254c43aada3655f2e85f75")
                 ->channels("CHb174f415825847399d884d55577c6924")
                 ->delete();

                 dd("done");
    }
}
