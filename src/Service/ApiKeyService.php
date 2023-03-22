<?php

namespace App\Service;



use Symfony\Component\HttpFoundation\Request;

class ApiKeyService
{
    /**
     * @param Request $request
     * @return bool
     */
    public function checkApiKey( Request $request ): bool
    {
        // Vérification de la requête

        // 1. Contient le header API-KEY ?
        // Attention les Headers HTTP ne peuvent pas avoir de underscore (c'est déprécié en tous cas)
        $API_KEY = $request->headers->get('API-KEY');

        // Contenu de API_KEY
        if ($API_KEY and strlen($API_KEY) == 42)
            $output = true;
        else
            $output = false;

        return $output;
    }
}