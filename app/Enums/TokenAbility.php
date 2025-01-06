<?php

namespace App\Enums;

enum TokenAbility: string
{
    case REFRESH_TOKEN = 'refresh_token';
    case ACCESS_API = 'access_token';
    case VERIFY_TOKEN = 'verify_token';
}
