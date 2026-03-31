<?php

namespace Tests\Feature;

use App\Models\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FornecedorPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_fornecedor_can_be_persisted_with_expected_fields(): void
    {
        $fornecedor = Fornecedor::create([
            'nome' => 'Fornecedor Teste',
            'email' => 'fornecedor@example.com',
            'telefone' => '(11) 99999-9999',
            'cnpj' => '12.345.678/0001-99',
        ]);

        $this->assertNotNull($fornecedor->id);

        $this->assertDatabaseHas('fornecedors', [
            'nome' => 'Fornecedor Teste',
            'email' => 'fornecedor@example.com',
            'telefone' => '(11) 99999-9999',
            'cnpj' => '12.345.678/0001-99',
        ]);
    }
}
