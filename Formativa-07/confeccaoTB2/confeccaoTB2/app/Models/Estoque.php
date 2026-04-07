<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $guarded = [];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    protected static function booted(): void
    {
        static::created(function ($estoque) {
            if ($estoque->produto) {
                $novaQuantidade = $estoque->tipo === 'entrada' 
                    ? ($estoque->produto->estoque + $estoque->quantidade)
                    : ($estoque->produto->estoque - $estoque->quantidade);
                
                // Atualiza sem disparar eventos
                $estoque->produto->withoutEvents(function () use ($estoque, $novaQuantidade) {
                    $estoque->produto->update(['estoque' => max(0, $novaQuantidade)]);
                });
            }
        });

        static::updated(function ($estoque) {
            if ($estoque->produto) {
                // Soma todos os outros registros
                $outrosRegistros = Estoque::where('produto_id', $estoque->produto_id)
                    ->where('id', '!=', $estoque->id)
                    ->get()
                    ->sum(fn($e) => $e->tipo === 'entrada' ? $e->quantidade : -$e->quantidade);
                
                // Adiciona o registro atual com seu novo valor
                $totalEstoque = $outrosRegistros + ($estoque->tipo === 'entrada' ? $estoque->quantidade : -$estoque->quantidade);
                
                // Atualiza sem disparar eventos
                $estoque->produto->withoutEvents(function () use ($estoque, $totalEstoque) {
                    $estoque->produto->update(['estoque' => max(0, $totalEstoque)]);
                });
            }
        });

        static::deleted(function ($estoque) {
            if ($estoque->produto) {
                $totalEstoque = Estoque::where('produto_id', $estoque->produto_id)
                    ->get()
                    ->sum(fn($e) => $e->tipo === 'entrada' ? $e->quantidade : -$e->quantidade);
                
                // Atualiza sem disparar eventos
                $estoque->produto->withoutEvents(function () use ($estoque, $totalEstoque) {
                    $estoque->produto->update(['estoque' => max(0, $totalEstoque)]);
                });
            }
        });
    }
}
