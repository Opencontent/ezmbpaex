<?php

class HaveIBeenPwned implements eZPaExValidatorInterface
{
    private const BASE_URI = 'https://api.pwnedpasswords.com';

    /**
     * @throws eZPaExValidatorException
     */
    public function validate(string $password): bool
    {
        if ($this->countPwnedPassword($password) > 0) {
            throw new eZPaExValidatorException(
                ezpI18n::tr(
                    "mbpaex/validation",
                    "This password has previously appeared in a data breach and should never be used. If you've ever used it anywhere before, change it!"
                )
            );
        }
        return true;
    }

    private function countPwnedPassword(string $password): int
    {
        $hashedPassword = strtoupper(sha1($password));
        $firstFiveCharacters = substr($hashedPassword, 0, 5);
        $hashes = $this->request('/range/' . $firstFiveCharacters);

        foreach ($hashes as $line) {
            if (false !== strpos($line, ':')) {
                list($hash, $count) = explode(':', $line);
                if ($firstFiveCharacters . strtoupper($hash) === $hashedPassword) {
                    return (int)$count;
                }
            }
        }

        return 0;
    }

    private function request($path): array
    {
        $url = self::BASE_URI . $path;
        $headers = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $data = curl_exec($ch);

        if ($data === false) {
            $errorCode = curl_errno($ch) * -1;
            $errorMessage = curl_error($ch);
            curl_close($ch);
            eZDebug::writeError("Error $errorCode: $errorMessage", __METHOD__);
            return [];
        }

        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['download_content_length'] > 0) {
            $body = substr($data, -$info['download_content_length']);
        } else {
            $body = substr($data, $info['header_size']);
        }

        if (intval($info['http_code']) > 299) {
            eZDebug::writeError("$url: Response is " . $info['http_code'] . ' ' . $data, __METHOD__);
            return [];
        }

        $hashes = str_replace("\r\n", PHP_EOL, $body);
        return explode(PHP_EOL, $hashes);
    }
}