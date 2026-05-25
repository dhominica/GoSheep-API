<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use App\Services\IoTService;

class MqttSubscriber extends Command
{
    protected $signature = 'mqtt:subscribe';

    protected $description = 'Subscribe MQTT environment data';

    public function handle(IoTService $iotService)
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe(
            'cages/+/environment',
            function (
                string $topic,
                string $message
            ) use ($iotService) {

                $this->info(
                    "Received from {$topic}: {$message}"
                );

                if (!preg_match(
                    '/cages\/(\d+)\/environment/',
                    $topic,
                    $matches
                )) {
                    return;
                }

                $cageId = (int) $matches[1];

                $data = json_decode(
                    $message,
                    true
                );

                if (
                    json_last_error() !== JSON_ERROR_NONE
                ) {
                    return;
                }

                $iotService->processEnvironmentData(
                    $cageId,
                    $data
                );
            }
        );

        $this->info('MQTT Subscriber running...');

        $mqtt->loop(true);
    }
}
