<?php

namespace Database\Seeders;

use App\Enums\OpportunityStage;
use App\Models\Client;
use App\Models\Company;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maria = User::where('email', 'maria@primepower.com')->firstOrFail();
        $juan = User::where('email', 'juan@primepower.com')->firstOrFail();

        $abc = Company::where(
            'name',
            'ABC Manufacturing Corporation'
        )->firstOrFail();

        $prime = Company::where(
            'name',
            'Prime Logistics Solutions'
        )->firstOrFail();

        $metro = Company::where(
            'name',
            'Metro Retail Corporation'
        )->firstOrFail();

        $abcLead = Lead::where('company_id', $abc->id)->firstOrFail();
        $primeLead = Lead::where('company_id', $prime->id)->firstOrFail();

        $metroClient = Client::where(
            'company_id',
            $metro->id
        )->firstOrFail();

        Opportunity::create([
            'company_id' => $abc->id,
            'lead_id' => $abcLead->id,
            'assigned_to_id' => $maria->id,
            'title' => 'Manufacturing Workforce Contract',
            'description' => 'Manpower requirements for production operations.',
            'stage' => OpportunityStage::NEGOTIATION,
            'manpower_requirement' => 50,
            'estimated_contract_value' => 1250000,
            'expected_close_date' => now()->addDays(20),
        ]);

        Opportunity::create([
            'company_id' => $prime->id,
            'lead_id' => $primeLead->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Warehouse Staffing Services',
            'description' => 'Initial staffing opportunity for warehouse operations.',
            'stage' => OpportunityStage::DISCUSSION,
            'manpower_requirement' => 30,
            'estimated_contract_value' => 750000,
            'expected_close_date' => now()->addDays(35),
        ]);

        Opportunity::create([
            'company_id' => $metro->id,
            'client_id' => $metroClient->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Additional Store Staffing',
            'description' => 'Additional manpower requirement for new retail locations.',
            'stage' => OpportunityStage::PROPOSAL,
            'manpower_requirement' => 20,
            'estimated_contract_value' => 500000,
            'expected_close_date' => now()->addDays(15),
        ]);

        Opportunity::create([
            'company_id' => $metro->id,
            'client_id' => $metroClient->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Seasonal Staffing',
            'description' => 'Seasonal manpower requirement.',
            'stage' => OpportunityStage::LOST,
            'manpower_requirement' => 15,
            'estimated_contract_value' => 300000,
            'expected_close_date' => now()->subDays(10),
            'lost_reason' => 'Client postponed the requirement.',
        ]);
    }
}
