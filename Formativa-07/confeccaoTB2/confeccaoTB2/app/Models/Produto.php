<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $guarded = [];

    public function estoque()
    {
        return $this->hasOne(Estoque::class);
    }

    protected static function booted(): void
    {
        static::created(function ($produto) {
            if ($produto->estoque > 0) {
                Estoque::withoutEvents(function () use ($produto) {
                    Estoque::create([
                        'produto_id' => $produto->id,
                        'quantidade' => $produto->estoque,
                        'tipo' => 'entrada',
                    ]);
                });
            }
        });

        static::updated(function ($produto) {
            if ($produto->isDirty('estoque')) {
                $novaQuantidade = $produto->estoque;
                $quantidadeAnterior = $produto->getOriginal('estoque');
                $diferenca = $novaQuantidade - $quantidadeAnterior;
                
                if ($diferenca > 0) {
                    // Adição
                    Estoque::withoutEvents(function () use ($produto, $diferenca) {
                        Estoque::create([
                            'produto_id' => $produto->id,
                            'quantidade' => $diferenca,
                            'tipo' => 'entrada',
                        ]);
                    });
                } elseif ($diferenca < 0) {
                    // Remoção
                    Estoque::withoutEvents(function () use ($produto, $diferenca) {
                        Estoque::create([
                            'produto_id' => $produto->id,
                            'quantidade' => abs($diferenca),
                            'tipo' => 'saída',
                        ]);
                    });
                }
            }
        });
    }
}
