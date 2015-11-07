<?php

namespace Tjbp\Countries\Build;

use Composer\Script\Event;
use Riimu\Kit\PHPEncoder\PHPEncoder;

class Iso3166
{
    /**
     * File location of class template.
     *
     * @var string
     */
    private $templateFile;

    /**
     * File location of generated class.
     *
     * @var string
     */
    private $outputFile;

    /**
     * PHPEncoder object.
     *
     * @var \Riimu\Kit\PHPEncoder\PHPEncoder
     */
    private $encoder;

    /**
     * Constructor sets object properties and injects dependencies.
     *
     * @return void
     */
    public function __construct()
    {
        $this->templateFile = __DIR__ . '/../templates/Iso3166.php';

        $this->outputFile = __DIR__ . '/../Iso3166.php';

        $this->encoder = new PHPEncoder;
    }

    /**
     * Return the raw data source.
     *
     * @return string
     */
    private function source()
    {
        $source_url = 'https://www.iso.org/obp/ui/';

        file_get_contents($source_url);

        foreach ($http_response_header as $header) {
            if (substr($header, 0, 10) != 'Set-Cookie') {
                continue;
            }

            $cookie = explode(';', substr($header, 12))[0];
        }

        $resource_info = file_get_contents($source_url, false, stream_context_create([
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\nCookie: {$cookie}\r\n",
                'method' => 'POST',
                'content' => 'v-browserDetails=1&v-loc=https%3A%2F%2Fwww.iso.org%2Fobp%2Fui%2F%23search'
            ],
        ]));

        $csrf_token = json_decode(json_decode($resource_info)->uidl)->{'Vaadin-Security-Key'};

        $rpc_calls = [
            '"rpc":[["0","com.vaadin.shared.ui.ui.UIServerRpc","resize",["448","1370","1370","448"]],["62","com.vaadin.ui.JavaScript$JavaScriptCallbackRpc","call",["onCaptureSessionNotFound",[null]]]], "syncId":1',
            '"rpc":[["18","v","v",["selected",["S",["6"]]]]], "syncId":2',
            '"rpc":[["24","com.vaadin.shared.communication.FieldRpc$FocusAndBlurServerRpc","focus",[]]], "syncId":3',
            '"rpc":[["24","com.vaadin.shared.ui.button.ButtonServerRpc","click",[{"metaKey":false, "type":"1", "button":"LEFT", "relativeY":"19", "relativeX":"9", "clientX":"1079", "clientY":"309", "ctrlKey":false, "shiftKey":false, "altKey":false}]]], "syncId":4',
            '"rpc":[["85","com.vaadin.shared.ui.csslayout.CssLayoutServerRpc","layoutClick",[{"metaKey":false, "type":"8", "button":"LEFT", "relativeY":"14", "relativeX":"105", "clientX":"117", "clientY":"375", "ctrlKey":false, "shiftKey":false, "altKey":false},"86"]]], "syncId":5',
            '"rpc":[["53","v","v",["selected",["S",["16"]]]]], "syncId":6'
        ];

        $source_url = 'https://www.iso.org/obp/ui/UIDL/?v-uiId=0';

        foreach ($rpc_calls as $rpc_call) {
            $json = '{
                "csrfToken":"' . $csrf_token . '",
                ' . $rpc_call . '
            }';

            $result = file_get_contents($source_url, false, stream_context_create([
                'http' => [
                    'header' => "Content-type: application/json;charset=UTF-8\r\nCookie: {$cookie}\r\n",
                    'method' => 'POST',
                    'content' => $json,
                ],
            ]));
        }

        return $result;
    }

    /**
     * Generate the class and save it to the filesystem.
     *
     * @return void
     */
    public function build()
    {
        $countries = [];

        $alpha3_index = [];

        $numeric3_index = [];

        $source = json_decode(substr($this->source(), 8))[0];

        foreach ($source->changes[1][2][2] as $index => $country) {
            if ($index < 2) {
                continue;
            }

            $countries[$country[4]] = [
                'name' => $source->state->{$country[2][1]->id}->caption,
                'alpha2' => $country[4],
                'alpha3' => $country[5],
                'numeric3' => $country[6],
            ];

            $alpha3_index[$country[5]] = $country[4];

            $numeric3_index[$country[6]] = $country[4];
        }

        $template = file_get_contents($this->templateFile);

        $template = str_replace(
            '/* countries */',
            '= ' . $this->encoder->encode($countries, ['array.base' => 4]),
            $template
        );

        $template = str_replace(
            '/* alpha3_index */',
            '= ' . $this->encoder->encode($alpha3_index, ['array.base' => 4]),
            $template
        );

        $template = str_replace(
            '/* numeric3_index */',
            '= ' . $this->encoder->encode($numeric3_index, ['array.base' => 4]),
            $template
        );

        file_put_contents(
            $this->outputFile,
            $template
        );
    }
}
