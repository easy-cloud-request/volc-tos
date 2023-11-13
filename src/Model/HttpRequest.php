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

namespace EasyCloudRequest\VolcTos\Model;

/**
 * source from volcengine HttpRequest
 *
 * @link https://github.com/volcengine/ve-tos-php-sdk/blob/main/src/Model/HttpRequest.php
 */
class HttpRequest
{
    /**
     * @var string
     */
    public $operation;
    /**
     * @var string
     */
    public $method;
    /**
     * @var string
     */
    public $bucket;
    /**
     * @var string
     */
    public $key;
    /**
     * @var array
     */
    public $headers;
    /**
     * @var array
     */
    public $queries;
    /**
     * @var mixed
     */
    public $body;
}
