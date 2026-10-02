<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('api');

        $token = $lava->api->get_bearer_token();
        $payload = $lava->api->validate_jwt($token ?? '');

        if (
            !$payload
            || ($payload['type'] ?? '') !== 'access'
            || !isset($payload['sub'])
            || !is_numeric($payload['sub'])
            || (int) $payload['sub'] < 1
        ) {
            $lava->api->respond_error('Unauthorized', 401);
        }

        return $next();
    }
}
