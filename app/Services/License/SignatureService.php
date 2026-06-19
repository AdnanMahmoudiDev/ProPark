<?php

namespace App\Services\License;

use Exception;

class SignatureService
{
    public function sign(array $data): string
    {
        unset($data['signature']);

        $data = $this->sortKeysRecursively($data);

        $dataJson = json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        if ($dataJson === false) {
            throw new Exception('Failed to encode data for signing.');
        }

        $privateKeyPath = storage_path('app/license_private.pem');

        if (!file_exists($privateKeyPath)) {
            throw new Exception("Private key not found at: " . $privateKeyPath);
        }

        $privateKeyContent = file_get_contents($privateKeyPath);

        if ($privateKeyContent === false) {
            throw new Exception('Failed to read private key.');
        }

        $signed = openssl_sign(
            $dataJson,
            $signature,
            $privateKeyContent,
            OPENSSL_ALGO_SHA256
        );

        if (!$signed) {
            throw new Exception('Failed to sign response.');
        }

        return base64_encode($signature);
    }

    private function sortKeysRecursively(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->sortKeysRecursively($value);
            }
        }

        if (!$this->isSequentialArray($data)) {
            ksort($data);
        }

        return $data;
    }

    private function isSequentialArray(array $data): bool
    {
        return array_keys($data) === range(0, count($data) - 1);
    }
}
