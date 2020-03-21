<?php

namespace App\Shared\Application\Http\Response;

interface JsonResponse
{
    public function responseCode(): int;
}