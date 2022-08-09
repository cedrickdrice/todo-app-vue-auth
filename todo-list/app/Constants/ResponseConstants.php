<?php

namespace App\Constants;

/**
 * Class ResponseConstants
 * @package App\Constants
 */
class ResponseConstants
{
    /**
     * HTTP OK request
     */
    const OK_REQUEST = 200;

    /**
     * HTTP OK But no content request
     */
    const NO_CONTENT_REQUEST = 204;

    /**
     * HTTP Error 400
     */
    const BAD_REQUEST = 400;

    /**
     * Unauthorized 401
     */
    const UNAUTHORIZED_REQUEST = 401;

    /**
     * HTTP ERROR 404
     */
    const NOT_FOUND = 404;

    /**
     * HTTP Error 422
     */
    const INVALID_PARAMETER_REQUEST = 422;

    /**
     * @var string data
     */
    const DATA = 'data';

    /**
     * @var string result
     */
    const RESULT = 'result';

    /**
     * @var string failed
     */
    const FAIL = 'failed';

    /**
     * @var string success
     */
    const SUCCESS = 'success';

    /**
     * @var string message
     */
    const MESSAGE = 'message';

    /**
     * @var string error list
     */
    const ERROR = 'errors';

    /**
     * No data message
     */
    const NO_DATA = 'Data not found';
}
