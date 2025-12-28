<?php

namespace Database\Seeders;

use App\Enums\DocumentTypeEnum;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patientsToCreate = [
            [
                'name' => 'Daniel Alvarez de Almeida',
                'admission_date' => now()->subDays(10),
                'document_type' => DocumentTypeEnum::CPF,
                'document_number' => '12345678900',
                'birthday' => '1990-05-15',
                'telephone' => '(11) 91234-5678',
            ],
            [
                'name' => 'Mariana Silva Costa',
                'admission_date' => now()->subDays(5),
                'document_type' => DocumentTypeEnum::RG,
                'document_number' => 'MG1234567',
                'birthday' => '1985-10-20',
                'telephone' => '(31) 99876-5432',
            ],
            [
                'name' => 'Miguel Pereira dos Santos',
                'admission_date' => now()->subDays(2),
                'document_type' => DocumentTypeEnum::CPF,
                'document_number' => '98765432100',
                'birthday' => '1978-03-12',
                'telephone' => '(21) 93456-7890',
            ]
        ];
        foreach ($patientsToCreate as $patient) {
            Patient::create($patient);
        }
        //generic generation 
        //Patient::factory()->count(10)->create();
    }
}
