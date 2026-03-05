<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\Json;

class SmsPilot extends Component
{
    private const API_URL = 'https://smspilot.ru/api.php';

    public string $apiKey;
    public string $sender = 'INFORM';

    public function send(string $to, string $text): bool
    {
        $url = self::API_URL . '?' . http_build_query([
            'send' => $text,
            'to' => $to,
            'from' => $this->sender,
            'apikey' => $this->apiKey,
            'format' => 'json'
        ]);

        try {
            $response = file_get_contents($url);
            $result = Json::decode($response);
            return isset($result['send']);
        } catch (\Exception $e) {
            \Yii::error("SMS error: " . $e->getMessage());
            return false;
        }
    }    
}