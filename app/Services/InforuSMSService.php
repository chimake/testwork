<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

class InforuSMSService
{
    protected function generateXMLMessage($phoneNumbers, $message): string
    {
        $xml = '<Inforu>'.PHP_EOL;
        $xml .= '  <User>'.PHP_EOL;
        $xml .= '    <Username>'.config('external-apis.inforu.login').'</Username>'.PHP_EOL;
        $xml .= '    <ApiToken>'.config('external-apis.inforu.api_token').'</ApiToken>'.PHP_EOL;
        $xml .= '  </User>'.PHP_EOL;
        $xml .= '  <Content Type="sms">'.PHP_EOL;
        $xml .= '    <Message>'.htmlspecialchars($message).'</Message>'.PHP_EOL;
        $xml .= '  </Content>'.PHP_EOL;
        $xml .= '  <Recipients>'.PHP_EOL;
        $xml .= '    <PhoneNumber>'.$phoneNumbers.'</PhoneNumber>'.PHP_EOL;
        $xml .= '  </Recipients>'.PHP_EOL;
        $xml .= '  <Settings>'.PHP_EOL;
        $xml .= '    <Sender>'.config('external-apis.inforu.sender_name').'</Sender>'.PHP_EOL;
        $xml .= '  </Settings>'.PHP_EOL;
        $xml .= '</Inforu>';

        return $xml;
    }

    public function sendMessage($phoneNumbers, $message)
    {
        $url = config('external-apis.inforu.xml_endpoint');

        $request = Http::get($url, [
            'InforuXML' => $this->generateXMLMessage($phoneNumbers, $message)
        ]);

        if ($request->failed()) {
            Log::error($request->body());
        }
    }
}