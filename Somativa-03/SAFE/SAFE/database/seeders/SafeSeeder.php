<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SafeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar responsáveis
        $guardians = [
            [
                'name' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'phone' => '(11) 98765-4321',
                'relationship' => 'Professor do dia',
                'document' => '123.456.789-00',
                'can_authorize_exit' => true,
                'receive_notifications' => true,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'phone' => '(11) 99876-5432',
                'relationship' => 'Professor do dia',
                'document' => '987.654.321-00',
                'can_authorize_exit' => true,
                'receive_notifications' => true,
            ],
            [
                'name' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'phone' => '(11) 97654-3210',
                'relationship' => 'Professor do dia',
                'document' => '456.789.123-00',
                'can_authorize_exit' => false,
                'receive_notifications' => true,
            ],
        ];

        foreach ($guardians as $guardian) {
            Guardian::create($guardian);
        }

        // Criar professores
        $teachers = [
            [
                'name' => 'Professora Ana',
                'email' => 'ana.professor@school.com',
                'registration' => 'PROF001',
                'class' => '5º Ano A',
                'can_authorize_exit' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Professor Carlos',
                'email' => 'carlos.professor@school.com',
                'registration' => 'PROF002',
                'class' => '5º Ano B',
                'can_authorize_exit' => true,
                'is_active' => true,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // Criar alunos
        $students = [
            [
                'name' => 'Lucas Silva',
                'registration' => 'ALU001',
                'class' => '5º Ano A',
                'guardian_id' => 1,
                'observations' => 'Aluno aplicado',
                'is_active' => true,
            ],
            [
                'name' => 'Sofia Santos',
                'registration' => 'ALU002',
                'class' => '5º Ano B',
                'guardian_id' => 2,
                'observations' => 'Aluna dedicada',
                'is_active' => true,
            ],
            [
                'name' => 'Gabriel Oliveira',
                'registration' => 'ALU003',
                'class' => '5º Ano A',
                'guardian_id' => 3,
                'observations' => 'Necessita acompanhamento',
                'is_active' => true,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        $this->command->info('Dados de teste criados com sucesso!');
    }
}
