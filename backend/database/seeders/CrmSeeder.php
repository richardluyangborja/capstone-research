<?php

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\LeadStatus;
use App\Enums\OpportunityStage;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\StageHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Daniel Balisi',
            'email' => 'daniel@primepower.com',
            'password' => 'password',
        ]);

        $maria = User::factory()->salesRep()->create([
            'name' => 'Maria Santos',
            'email' => 'maria@primepower.com',
            'password' => 'password',
        ]);

        $juan = User::factory()->salesRep()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@primepower.com',
            'password' => 'password',
        ]);

        User::factory()->manager()->create([
            'name' => 'Ana Reyes',
            'email' => 'ana@primepower.com',
            'password' => 'password',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        $abcManufacturing = Company::create([
            'name' => 'ABC Manufacturing Corporation',
            'industry' => 'Manufacturing',
            'address' => 'Quezon City, Metro Manila',
            'phone' => '+63 981 235 4500',
            'email' => 'info@abcmanufacturing.example',
            'website' => 'https://abcmanufacturing.example',
        ]);

        $primeLogistics = Company::create([
            'name' => 'Prime Logistics Solutions',
            'industry' => 'Logistics',
            'address' => 'Pasig City, Metro Manila',
            'phone' => '+63 947 234 5600',
            'email' => 'info@primelogistics.example',
            'website' => 'https://primelogistics.example',
        ]);

        $metroRetail = Company::create([
            'name' => 'Metro Retail Corporation',
            'industry' => 'Retail',
            'address' => 'Makati City, Metro Manila',
            'phone' => '+63 952 845 6700',
            'email' => 'info@metroretail.example',
            'website' => 'https://metroretail.example',
        ]);

        $goldenFoods = Company::create([
            'name' => 'Golden Foods Incorporated',
            'industry' => 'Food & Beverage',
            'address' => 'Manila, Metro Manila',
            'phone' => '+63 942 856 7800',
            'email' => 'info@goldenfoods.example',
            'website' => 'https://goldenfoods.example',
        ]);

        $pacificProperties = Company::create([
            'name' => 'Pacific Properties Group',
            'industry' => 'Real Estate',
            'address' => 'Taguig City, Metro Manila',
            'phone' => '+63 921 867 8900',
            'email' => 'info@pacificproperties.example',
            'website' => 'https://pacificproperties.example',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Contacts
        |--------------------------------------------------------------------------
        */

        Contact::create([
            'company_id' => $abcManufacturing->id,
            'first_name' => 'Robert',
            'last_name' => 'Santos',
            'title' => 'HR Manager',
            'email' => 'robert.santos@abcmanufacturing.example',
            'phone' => '+63 917 123 4567',
            'is_primary' => true,
        ]);

        Contact::create([
            'company_id' => $abcManufacturing->id,
            'first_name' => 'Angela',
            'last_name' => 'Reyes',
            'title' => 'Operations Manager',
            'email' => 'angela.reyes@abcmanufacturing.example',
            'phone' => '+63 918 234 5678',
            'is_primary' => false,
        ]);

        Contact::create([
            'company_id' => $primeLogistics->id,
            'first_name' => 'Michael',
            'last_name' => 'Cruz',
            'title' => 'HR Director',
            'email' => 'michael.cruz@primelogistics.example',
            'phone' => '+63 919 345 6789',
            'is_primary' => true,
        ]);

        Contact::create([
            'company_id' => $metroRetail->id,
            'first_name' => 'Patricia',
            'last_name' => 'Garcia',
            'title' => 'Procurement Manager',
            'email' => 'patricia.garcia@metroretail.example',
            'phone' => '+63 920 456 7890',
            'is_primary' => true,
        ]);

        Contact::create([
            'company_id' => $goldenFoods->id,
            'first_name' => 'Daniel',
            'last_name' => 'Torres',
            'title' => 'HR Supervisor',
            'email' => 'daniel.torres@goldenfoods.example',
            'phone' => '+63 921 567 8901',
            'is_primary' => true,
        ]);

        Contact::create([
            'company_id' => $pacificProperties->id,
            'first_name' => 'Sophia',
            'last_name' => 'Mendoza',
            'title' => 'Administrative Manager',
            'email' => 'sophia.mendoza@pacificproperties.example',
            'phone' => '+63 922 678 9012',
            'is_primary' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Leads
        |--------------------------------------------------------------------------
        */

        Lead::create([
            'company_id' => $abcManufacturing->id,
            'assigned_to_id' => $maria->id,
            'source' => 'Referral',
            'status' => LeadStatus::QUALIFIED,
            'notes' => 'Interested in acquiring manufacturing workforce services.',
        ]);

        Lead::create([
            'company_id' => $primeLogistics->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Website Inquiry',
            'status' => LeadStatus::NEW,
            'notes' => 'Initial inquiry regarding warehouse staffing requirements.',
        ]);

        Lead::create([
            'company_id' => $goldenFoods->id,
            'assigned_to_id' => $maria->id,
            'source' => 'Cold Outreach',
            'status' => LeadStatus::QUALIFIED,
            'notes' => 'Initial discussion completed with HR department.',
        ]);

        Lead::create([
            'company_id' => $pacificProperties->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Referral',
            'status' => LeadStatus::DISQUALIFIED,
            'notes' => 'Current staffing requirements do not match available services.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        Client::create([
            'company_id' => $metroRetail->id,
            'assigned_to_id' => $juan->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(8)->toDateString(),
            'notes' => 'Active manpower service client.',
        ]);

        Client::create([
            'company_id' => $abcManufacturing->id,
            'assigned_to_id' => $maria->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(5)->toDateString(),
            'notes' => 'Long-term manufacturing workforce partner.',
        ]);

        Client::create([
            'company_id' => $primeLogistics->id,
            'assigned_to_id' => $juan->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(3)->toDateString(),
            'notes' => 'Logistics staffing and warehouse personnel provider.',
        ]);

        Client::create([
            'company_id' => $goldenFoods->id,
            'assigned_to_id' => $maria->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(1)->toDateString(),
            'notes' => 'Food and beverage production manpower client.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Opportunities
        |--------------------------------------------------------------------------
        */

        $abcManufacturingOpp = Opportunity::create([
            'company_id' => $abcManufacturing->id,
            'lead_id' => $abcManufacturing->leads()->first()->id ?? null,
            'client_id' => $abcManufacturing->client->id ?? null,
            'assigned_to_id' => $maria->id,
            'title' => 'Production Line Staffing',
            'description' => 'Supply 50 production workers for 12 months.',
            'stage' => OpportunityStage::PROPOSAL,
            'manpower_requirement' => 50,
            'estimated_contract_value' => 1800000.00,
            'expected_close_date' => now()->addMonths(2)->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $abcManufacturingOpp->id,
            'user_id' => $maria->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Initial outreach via referral from existing client.',
            'created_at' => now()->subDays(30),
        ]);

        StageHistory::create([
            'opportunity_id' => $abcManufacturingOpp->id,
            'user_id' => $maria->id,
            'from_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'to_stage' => OpportunityStage::DISCUSSION->value,
            'reason' => 'Initial meeting completed with operations manager.',
            'created_at' => now()->subDays(20),
        ]);

        StageHistory::create([
            'opportunity_id' => $abcManufacturingOpp->id,
            'user_id' => $maria->id,
            'from_stage' => OpportunityStage::DISCUSSION->value,
            'to_stage' => OpportunityStage::PROPOSAL->value,
            'reason' => 'Client requested a formal proposal for 50 production workers.',
            'created_at' => now()->subDays(10),
        ]);

        $primeLogisticsOpp = Opportunity::create([
            'company_id' => $primeLogistics->id,
            'lead_id' => $primeLogistics->leads()->first()->id ?? null,
            'client_id' => $primeLogistics->client->id ?? null,
            'assigned_to_id' => $juan->id,
            'title' => 'Warehouse Associate Deployment',
            'description' => 'Provide 30 warehouse associates for peak season.',
            'stage' => OpportunityStage::NEGOTIATION,
            'manpower_requirement' => 30,
            'estimated_contract_value' => 960000.00,
            'expected_close_date' => now()->addMonth()->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $primeLogisticsOpp->id,
            'user_id' => $juan->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Inquiry received from warehouse operations manager.',
            'created_at' => now()->subDays(35),
        ]);

        StageHistory::create([
            'opportunity_id' => $primeLogisticsOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'to_stage' => OpportunityStage::DISCUSSION->value,
            'reason' => 'Discussed staffing requirements for peak season.',
            'created_at' => now()->subDays(25),
        ]);

        StageHistory::create([
            'opportunity_id' => $primeLogisticsOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::DISCUSSION->value,
            'to_stage' => OpportunityStage::PROPOSAL->value,
            'reason' => 'Proposal drafted for 30 warehouse associates.',
            'created_at' => now()->subDays(15),
        ]);

        StageHistory::create([
            'opportunity_id' => $primeLogisticsOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::PROPOSAL->value,
            'to_stage' => OpportunityStage::NEGOTIATION->value,
            'reason' => 'Client is reviewing terms and conditions.',
            'created_at' => now()->subDays(5),
        ]);

        $metroRetailWonOpp = Opportunity::create([
            'company_id' => $metroRetail->id,
            'lead_id' => null,
            'client_id' => $metroRetail->client->id ?? null,
            'assigned_to_id' => $juan->id,
            'title' => 'Seasonal Store Staffing',
            'description' => 'Deploy 20 sales associates for holiday season.',
            'stage' => OpportunityStage::WON,
            'manpower_requirement' => 20,
            'estimated_contract_value' => 720000.00,
            'expected_close_date' => now()->subWeek()->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Client expressed interest in holiday staffing.',
            'created_at' => now()->subMonths(3),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'to_stage' => OpportunityStage::DISCUSSION->value,
            'reason' => 'Initial requirements gathering session completed.',
            'created_at' => now()->subMonths(2)->addDays(20),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::DISCUSSION->value,
            'to_stage' => OpportunityStage::PROPOSAL->value,
            'reason' => 'Formal proposal submitted for 20 sales associates.',
            'created_at' => now()->subMonths(2),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::PROPOSAL->value,
            'to_stage' => OpportunityStage::NEGOTIATION->value,
            'reason' => 'Client requested adjustments to proposal terms.',
            'created_at' => now()->subMonths(1)->addDays(15),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::NEGOTIATION->value,
            'to_stage' => OpportunityStage::CONTRACT_PROCESSING->value,
            'reason' => 'Terms agreed upon. Moving to contract drafting.',
            'created_at' => now()->subMonths(1),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroRetailWonOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::CONTRACT_PROCESSING->value,
            'to_stage' => OpportunityStage::WON->value,
            'reason' => 'Contract signed. Opportunity marked as won.',
            'created_at' => now()->subWeek(),
        ]);

        $goldenFoodsOpp = Opportunity::create([
            'company_id' => $goldenFoods->id,
            'lead_id' => $goldenFoods->leads()->first()->id ?? null,
            'client_id' => $goldenFoods->client->id ?? null,
            'assigned_to_id' => $maria->id,
            'title' => 'Packaging Line Support',
            'description' => 'Supply 25 packaging line helpers for 6 months.',
            'stage' => OpportunityStage::DISCUSSION,
            'manpower_requirement' => 25,
            'estimated_contract_value' => 540000.00,
            'expected_close_date' => now()->addMonths(3)->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $goldenFoodsOpp->id,
            'user_id' => $maria->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Initial cold outreach via LinkedIn contact.',
            'created_at' => now()->subDays(15),
        ]);

        StageHistory::create([
            'opportunity_id' => $goldenFoodsOpp->id,
            'user_id' => $maria->id,
            'from_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'to_stage' => OpportunityStage::DISCUSSION->value,
            'reason' => 'First meeting held with HR supervisor.',
            'created_at' => now()->subDays(5),
        ]);

        $pacificPropertiesOpp = Opportunity::create([
            'company_id' => $pacificProperties->id,
            'lead_id' => $pacificProperties->leads()->first()->id ?? null,
            'client_id' => null,
            'assigned_to_id' => $juan->id,
            'title' => 'Construction Site Manpower',
            'description' => 'Provide general helpers for ongoing construction projects.',
            'stage' => OpportunityStage::INITIAL_CONTACT,
            'manpower_requirement' => 40,
            'estimated_contract_value' => 1200000.00,
            'expected_close_date' => now()->addMonths(4)->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $pacificPropertiesOpp->id,
            'user_id' => $juan->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Referral inquiry for construction site staffing.',
            'created_at' => now()->subDays(10),
        ]);

        $metroInventoryOpp = Opportunity::create([
            'company_id' => $metroRetail->id,
            'lead_id' => null,
            'client_id' => $metroRetail->client->id ?? null,
            'assigned_to_id' => $juan->id,
            'title' => 'Inventory Staffing',
            'description' => 'Supply 15 inventory clerks for warehouse operations.',
            'stage' => OpportunityStage::CONTRACT_PROCESSING,
            'manpower_requirement' => 15,
            'estimated_contract_value' => 450000.00,
            'expected_close_date' => now()->addWeeks(2)->toDateString(),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroInventoryOpp->id,
            'user_id' => $juan->id,
            'from_stage' => null,
            'to_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'reason' => 'Request for inventory staffing during peak season.',
            'created_at' => now()->subMonths(2),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroInventoryOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::INITIAL_CONTACT->value,
            'to_stage' => OpportunityStage::DISCUSSION->value,
            'reason' => 'Discussed staffing needs for inventory operations.',
            'created_at' => now()->subMonths(1)->addDays(20),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroInventoryOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::DISCUSSION->value,
            'to_stage' => OpportunityStage::PROPOSAL->value,
            'reason' => 'Proposal submitted for 15 inventory clerks.',
            'created_at' => now()->subMonth(),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroInventoryOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::PROPOSAL->value,
            'to_stage' => OpportunityStage::NEGOTIATION->value,
            'reason' => 'Negotiation on contract terms and rates.',
            'created_at' => now()->subWeeks(2),
        ]);

        StageHistory::create([
            'opportunity_id' => $metroInventoryOpp->id,
            'user_id' => $juan->id,
            'from_stage' => OpportunityStage::NEGOTIATION->value,
            'to_stage' => OpportunityStage::CONTRACT_PROCESSING->value,
            'reason' => 'Terms finalized. Legal review in progress.',
            'created_at' => now()->subWeek(),
        ]);
    }
}
