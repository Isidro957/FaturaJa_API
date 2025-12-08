<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;

class ResolveEmpresa
{
    public function handle($request, Closure $next)
    {
        $slug = $request->header('X-Empresa-Slug');

        if (!$slug) {
            return response()->json(['message' => 'X-Empresa-Slug não enviado'], 400);
        }

        $empresa = Empresa::where('slug', $slug)->first();

        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        app()->instance('empresaAtual', $empresa);

        return $next($request);
    }
}
