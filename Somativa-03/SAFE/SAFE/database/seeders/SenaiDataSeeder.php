<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SenaiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== CRIAR SALAS SENAI =====
        $classrooms = [
            [
                'name' => 'SENAI - Sala 101 (Bloco A)',
                'code' => 'SALA-101',
                'block' => 'Bloco A',
                'capacity' => 30,
                'location' => 'Andar 1 - Ala Leste',
                'is_active' => true,
            ],
            [
                'name' => 'SENAI - Sala 102 (Bloco A)',
                'code' => 'SALA-102',
                'block' => 'Bloco A',
                'capacity' => 30,
                'location' => 'Andar 1 - Ala Leste',
                'is_active' => true,
            ],
            [
                'name' => 'SENAI - Sala 201 (Bloco B)',
                'code' => 'SALA-201',
                'block' => 'Bloco B',
                'capacity' => 25,
                'location' => 'Andar 2 - Ala Central',
                'is_active' => true,
            ],
            [
                'name' => 'SENAI - Sala 202 (Bloco B)',
                'code' => 'SALA-202',
                'block' => 'Bloco B',
                'capacity' => 28,
                'location' => 'Andar 2 - Ala Central',
                'is_active' => true,
            ],
            [
                'name' => 'SENAI - Sala 301 (Bloco C)',
                'code' => 'SALA-301',
                'block' => 'Bloco C',
                'capacity' => 32,
                'location' => 'Andar 3 - Ala Oeste',
                'is_active' => true,
            ],
        ];

        $createdClassrooms = [];
        foreach ($classrooms as $classroom) {
            $createdClassrooms[] = Classroom::create($classroom);
        }

        // ===== CRIAR USUÁRIOS COM ROLES =====
        
        // Admin
        $admin = User::create([
            'name' => 'Administrador SENAI',
            'email' => 'admin@senai.com.br',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Professores
        $professor1 = User::create([
            'name' => 'Prof. Carlos Silva',
            'email' => 'carlos.silva@senai.com.br',
            'password' => Hash::make('prof123'),
            'role' => 'professor',
        ]);

        $professor2 = User::create([
            'name' => 'Prof. Ana Santos',
            'email' => 'ana.santos@senai.com.br',
            'password' => Hash::make('prof123'),
            'role' => 'professor',
        ]);

        // Portaria
        $portaria = User::create([
            'name' => 'Porteiro SENAI',
            'email' => 'portaria@senai.com.br',
            'password' => Hash::make('portaria123'),
            'role' => 'portaria',
        ]);

        // ===== ASSOCIAR SALAS AOS PROFESSORES =====
        $professor1->classrooms()->attach([$createdClassrooms[0]->id, $createdClassrooms[1]->id]);
        $professor2->classrooms()->attach([$createdClassrooms[2]->id, $createdClassrooms[3]->id, $createdClassrooms[4]->id]);

        // ===== CRIAR RESPONSÁVEIS =====
        $guardians = [
            Guardian::create([
                'name' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'phone' => '(11) 98765-4321',
                'relationship' => 'Professor do dia',
                'document' => '12345678900',
                'can_authorize_exit' => true,
                'receive_notifications' => true,
            ]),
            Guardian::create([
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'phone' => '(11) 99876-5432',
                'relationship' => 'Professor do dia',
                'document' => '12345678901',
                'can_authorize_exit' => true,
                'receive_notifications' => true,
            ]),
            Guardian::create([
                'name' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'phone' => '(11) 97654-3210',
                'relationship' => 'Professor do dia',
                'document' => '12345678902',
                'can_authorize_exit' => false,
                'receive_notifications' => true,
            ]),
        ];

        // ===== CRIAR ALUNOS =====
        $students = [
            Student::create([
                'name' => 'Lucas Silva',
                'registration' => 'ALU001',
                'class' => 'SENAI - Sala 101 (Bloco A)',
                'guardian_id' => $guardians[0]->id,
                'is_active' => true,
                'observations' => 'Aluno exemplar',
            ]),
            Student::create([
                'name' => 'Sofia Santos',
                'registration' => 'ALU002',
                'class' => 'SENAI - Sala 102 (Bloco A)',
                'guardian_id' => $guardians[1]->id,
                'is_active' => true,
                'observations' => 'Aluno aplicado',
            ]),
            Student::create([
                'name' => 'Gabriel Oliveira',
                'registration' => 'ALU003',
                'class' => 'SENAI - Sala 201 (Bloco B)',
                'guardian_id' => $guardians[2]->id,
                'is_active' => true,
                'observations' => null,
            ]),
            Student::create([
                'name' => 'Juliana Costa',
                'registration' => 'ALU004',
                'class' => 'SENAI - Sala 201 (Bloco B)',
                'guardian_id' => $guardians[0]->id,
                'is_active' => true,
                'observations' => 'Destaque em matemática',
            ]),
            Student::create([
                'name' => 'Felipe Mendes',
                'registration' => 'ALU005',
                'class' => 'SENAI - Sala 301 (Bloco C)',
                'guardian_id' => $guardians[1]->id,
                'is_active' => true,
                'observations' => null,
            ]),
        ];
    }
}
