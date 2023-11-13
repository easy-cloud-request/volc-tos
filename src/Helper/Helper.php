<?php
/**
 * Copyright (2022) Volcengine
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace EasyCloudRequest\VolcTos\Helper;

use EasyCloudRequest\Core\Exceptions\InvalidArgumentException;

/**
 * source from volcengine Helper
 *
 * @link https://github.com/volcengine/ve-tos-php-sdk/blob/main/src/Helper/Helper.php
 */
class Helper
{
    public static function urlencodeWithSafe($val, $safe = '/')
    {
        if (!$val) {
            return '';
        }

        if (($len = strlen($val)) === 0) {
            return '';
        }
        $buffer = [];
        for ($index = 0; $index < $len; $index++) {
            $str = $val[$index];
            $buffer[] = !($pos = strpos($safe, $str)) && $pos !== 0 ? rawurlencode($str) : $str;
        }
        return implode('', $buffer);
    }

    public static function urlEncodeChinese($val)
    {
        $result = '';
        for ($i = 0; $i < mb_strlen($val, 'UTF-8'); $i++) {
            $item = mb_substr($val, $i, 1, 'UTF-8');
            $result .= preg_match('/[\x{4e00}-\x{9fa5}]/u', $item) ? rawurlencode($item) : $item;
            ;
        }
        return $result;
    }

    public static function &splitEndpoint($endpoint)
    {
        $endpoint = strtolower($endpoint);
        while (($len = strlen($endpoint)) > 0 && $endpoint[$len - 1] === '/') {
            $endpoint = substr($endpoint, 0, $len - 1);
        }

        if ($endpoint === '') {
            throw new InvalidArgumentException('invalid endpoint', 500);
        }

        if (strpos($endpoint, 'http://') === 0) {
            $schema = 'http://';
            $domain = substr($endpoint, strlen('http://'));
        } elseif (strpos($endpoint, 'https://') === 0) {
            $schema = 'https://';
            $domain = substr($endpoint, strlen('https://'));
        } else {
            $schema = 'https://';
            $domain = $endpoint;
        }

        $host = $domain;
        if (($idx = strpos($domain, ':')) >= 0) {
            $host = substr($domain, 0, $idx);
        }

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('ip address is not supported', 500);
        }
        $result = ['domain' => $domain, 'schema' => $schema];
        return $result;
    }
}
