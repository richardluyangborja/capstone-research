<?php

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\CommunicationDirection;
use App\Enums\CommunicationType;
use App\Enums\LeadStatus;
use App\Enums\OpportunityStage;
use App\Enums\ReminderPriority;
use App\Models\Client;
use App\Models\ClientSurvey;
use App\Models\Communication;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Reminder;
use App\Models\StageHistory;
use App\Models\StatusHistory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->admin()->create([
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
        | Lead Companies (3)
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

        $abcLead = Lead::create([
            'company_id' => $abcManufacturing->id,
            'assigned_to_id' => $maria->id,
            'source' => 'Referral',
            'status' => LeadStatus::QUALIFIED,
            'notes' => 'Interested in acquiring manufacturing workforce services.',
        ]);

        $primeLogistics = Company::create([
            'name' => 'Prime Logistics Solutions',
            'industry' => 'Logistics',
            'address' => 'Pasig City, Metro Manila',
            'phone' => '+63 947 234 5600',
            'email' => 'info@primelogistics.example',
            'website' => 'https://primelogistics.example',
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
            'company_id' => $primeLogistics->id,
            'first_name' => 'Sarah',
            'last_name' => 'Chen',
            'title' => 'Operations Coordinator',
            'email' => 'sarah.chen@primelogistics.example',
            'phone' => '+63 918 234 5678',
            'is_primary' => false,
        ]);

        $primeLead = Lead::create([
            'company_id' => $primeLogistics->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Website Inquiry',
            'status' => LeadStatus::NEW,
            'notes' => 'Initial inquiry regarding warehouse staffing requirements.',
        ]);

        $goldenFoods = Company::create([
            'name' => 'Golden Foods Incorporated',
            'industry' => 'Food & Beverage',
            'address' => 'Manila, Metro Manila',
            'phone' => '+63 942 856 7800',
            'email' => 'info@goldenfoods.example',
            'website' => 'https://goldenfoods.example',
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
            'company_id' => $goldenFoods->id,
            'first_name' => 'Lisa',
            'last_name' => 'Wong',
            'title' => 'Procurement Manager',
            'email' => 'lisa.wong@goldenfoods.example',
            'phone' => '+63 922 345 6789',
            'is_primary' => false,
        ]);

        $goldenLead = Lead::create([
            'company_id' => $goldenFoods->id,
            'assigned_to_id' => $maria->id,
            'source' => 'Cold Outreach',
            'status' => LeadStatus::QUALIFIED,
            'notes' => 'Initial discussion completed with HR department.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Client Companies (2)
        |--------------------------------------------------------------------------
        */

        $metroRetail = Company::create([
            'name' => 'Metro Retail Corporation',
            'industry' => 'Retail',
            'address' => 'Makati City, Metro Manila',
            'phone' => '+63 952 845 6700',
            'email' => 'info@metroretail.example',
            'website' => 'https://metroretail.example',
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
            'company_id' => $metroRetail->id,
            'first_name' => 'Carlos',
            'last_name' => 'Diaz',
            'title' => 'Store Manager',
            'email' => 'carlos.diaz@metroretail.example',
            'phone' => '+63 921 234 5678',
            'is_primary' => false,
        ]);

        $metroLead = Lead::create([
            'company_id' => $metroRetail->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Referral',
            'status' => LeadStatus::CONVERTED,
            'notes' => 'Initial inquiry for seasonal staffing. Converted after winning Seasonal Store Staffing contract.',
        ]);

        Client::create([
            'company_id' => $metroRetail->id,
            'lead_id' => $metroLead->id,
            'assigned_to_id' => $juan->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(8)->toDateString(),
            'notes' => 'Active manpower service client.',
        ]);

        // Metro Retail surveys
        ClientSurvey::create([
            'client_id' => $metroRetail->client->id,
            'token' => 'srv_metro_001',
            'status' => 'completed',
            'responses' => [
                ['question_id' => 'q1', 'score' => 4],
                ['question_id' => 'q2', 'score' => 5],
                ['question_id' => 'q3', 'score' => 4],
                ['question_id' => 'q4', 'score' => 5],
                ['question_id' => 'q5', 'score' => 4],
            ],
            'average_score' => 4.4,
            'completed_at' => now()->subDays(45),
        ]);

        ClientSurvey::create([
            'client_id' => $metroRetail->client->id,
            'token' => 'srv_metro_002',
            'status' => 'completed',
            'responses' => [
                ['question_id' => 'q1', 'score' => 5],
                ['question_id' => 'q2', 'score' => 5],
                ['question_id' => 'q3', 'score' => 4],
                ['question_id' => 'q4', 'score' => 5],
                ['question_id' => 'q5', 'score' => 5],
            ],
            'average_score' => 4.8,
            'completed_at' => now()->subDays(10),
        ]);

        ClientSurvey::create([
            'client_id' => $metroRetail->client->id,
            'token' => 'srv_metro_003',
            'status' => 'pending',
            'responses' => null,
            'average_score' => null,
            'completed_at' => null,
        ]);

        $pacificProperties = Company::create([
            'name' => 'Pacific Properties Group',
            'industry' => 'Real Estate',
            'address' => 'Taguig City, Metro Manila',
            'phone' => '+63 921 867 8900',
            'email' => 'info@pacificproperties.example',
            'website' => 'https://pacificproperties.example',
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

        Contact::create([
            'company_id' => $pacificProperties->id,
            'first_name' => 'David',
            'last_name' => 'Kim',
            'title' => 'Project Manager',
            'email' => 'david.kim@pacificproperties.example',
            'phone' => '+63 923 456 7890',
            'is_primary' => false,
        ]);

        $pacificLead = Lead::create([
            'company_id' => $pacificProperties->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Referral',
            'status' => LeadStatus::CONVERTED,
            'notes' => 'Initial inquiry for construction site staffing. Converted after contract award.',
        ]);

        Client::create([
            'company_id' => $pacificProperties->id,
            'lead_id' => $pacificLead->id,
            'assigned_to_id' => $juan->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(3)->toDateString(),
            'notes' => 'Construction and site staffing provider.',
        ]);

        // Pacific Properties surveys
        ClientSurvey::create([
            'client_id' => $pacificProperties->client->id,
            'token' => 'srv_pacific_001',
            'status' => 'completed',
            'responses' => [
                ['question_id' => 'q1', 'score' => 5],
                ['question_id' => 'q2', 'score' => 5],
                ['question_id' => 'q3', 'score' => 5],
                ['question_id' => 'q4', 'score' => 5],
                ['question_id' => 'q5', 'score' => 5],
            ],
            'average_score' => 5.0,
            'completed_at' => now()->subDays(30),
        ]);

        ClientSurvey::create([
            'client_id' => $pacificProperties->client->id,
            'token' => 'srv_pacific_002',
            'status' => 'expired',
            'responses' => null,
            'average_score' => null,
            'completed_at' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Opportunities + Stage Histories
        |--------------------------------------------------------------------------
        | Lead Companies:
        |   - ABC Manufacturing (QUALIFIED): Proposal stage
        |   - Prime Logistics (NEW): Negotiation stage — should show qualification alert
        |   - Golden Foods (QUALIFIED): Discussion stage
        |   - Summit Corporate Solutions (CONVERTED): Won opportunity
        |
        | Client Companies:
        |   - Metro Retail: Won + Contract Processing
        |   - Pacific Properties: Proposal
        |--------------------------------------------------------------------------
        */

        // ABC Manufacturing — PROPOSAL (qualified lead, no alert)
        $abcOpp = Opportunity::create([
            'company_id' => $abcManufacturing->id,
            'lead_id' => $abcLead->id,
            'assigned_to_id' => $maria->id,
            'title' => 'Production Line Staffing',
            'description' => 'Supply 50 production workers for 12 months.',
            'stage' => OpportunityStage::PROPOSAL,
            'manpower_requirement' => 50,
            'estimated_contract_value' => 1800000.00,
            'expected_close_date' => now()->addMonths(2)->toDateString(),
        ]);

        $this->createStageHistories($abcOpp, $maria->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Initial outreach via referral from existing client.', now()->subDays(30)],
            [OpportunityStage::DISCUSSION, 'Initial meeting completed with operations manager.', now()->subDays(20)],
            [OpportunityStage::PROPOSAL, 'Client requested a formal proposal for 50 production workers.', now()->subDays(10)],
        ]);

        // Prime Logistics — NEGOTIATION (new lead, triggers alert)
        $primeOpp = Opportunity::create([
            'company_id' => $primeLogistics->id,
            'lead_id' => $primeLead->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Warehouse Associate Deployment',
            'description' => 'Provide 30 warehouse associates for peak season.',
            'stage' => OpportunityStage::NEGOTIATION,
            'manpower_requirement' => 30,
            'estimated_contract_value' => 960000.00,
            'expected_close_date' => now()->addMonth()->toDateString(),
        ]);

        $this->createStageHistories($primeOpp, $juan->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Inquiry received from warehouse operations manager.', now()->subDays(35)],
            [OpportunityStage::DISCUSSION, 'Discussed staffing requirements for peak season.', now()->subDays(25)],
            [OpportunityStage::PROPOSAL, 'Proposal drafted for 30 warehouse associates.', now()->subDays(15)],
            [OpportunityStage::NEGOTIATION, 'Client is reviewing terms and conditions.', now()->subDays(5)],
        ]);

        // Golden Foods — DISCUSSION (qualified lead, no alert)
        $goldenOpp = Opportunity::create([
            'company_id' => $goldenFoods->id,
            'lead_id' => $goldenLead->id,
            'assigned_to_id' => $maria->id,
            'title' => 'Packaging Line Support',
            'description' => 'Supply 25 packaging line helpers for 6 months.',
            'stage' => OpportunityStage::DISCUSSION,
            'manpower_requirement' => 25,
            'estimated_contract_value' => 540000.00,
            'expected_close_date' => now()->addMonths(3)->toDateString(),
        ]);

        $this->createStageHistories($goldenOpp, $maria->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Initial cold outreach via LinkedIn contact.', now()->subDays(15)],
            [OpportunityStage::DISCUSSION, 'First meeting held with HR supervisor.', now()->subDays(5)],
        ]);

        // Metro Retail — WON (full pipeline)
        $metroWonOpp = Opportunity::create([
            'company_id' => $metroRetail->id,
            'client_id' => $metroRetail->client->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Seasonal Store Staffing',
            'description' => 'Deploy 20 sales associates for holiday season.',
            'stage' => OpportunityStage::WON,
            'manpower_requirement' => 20,
            'estimated_contract_value' => 720000.00,
            'expected_close_date' => now()->subWeek()->toDateString(),
        ]);

        $this->createStageHistories($metroWonOpp, $juan->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Client expressed interest in holiday staffing.', now()->subMonths(3)],
            [OpportunityStage::DISCUSSION, 'Initial requirements gathering session completed.', now()->subMonths(2)->addDays(20)],
            [OpportunityStage::PROPOSAL, 'Formal proposal submitted for 20 sales associates.', now()->subMonths(2)],
            [OpportunityStage::NEGOTIATION, 'Client requested adjustments to proposal terms.', now()->subMonths(1)->addDays(15)],
            [OpportunityStage::CONTRACT_PROCESSING, 'Terms agreed upon. Moving to contract drafting.', now()->subMonths(1)],
            [OpportunityStage::WON, 'Contract signed. Opportunity marked as won.', now()->subWeek()],
        ]);

        // Metro Retail — CONTRACT_PROCESSING (ongoing)
        $metroInventoryOpp = Opportunity::create([
            'company_id' => $metroRetail->id,
            'client_id' => $metroRetail->client->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Inventory Staffing',
            'description' => 'Supply 15 inventory clerks for warehouse operations.',
            'stage' => OpportunityStage::CONTRACT_PROCESSING,
            'manpower_requirement' => 15,
            'estimated_contract_value' => 450000.00,
            'expected_close_date' => now()->addWeeks(2)->toDateString(),
        ]);

        $this->createStageHistories($metroInventoryOpp, $juan->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Request for inventory staffing during peak season.', now()->subMonths(2)],
            [OpportunityStage::DISCUSSION, 'Discussed staffing needs for inventory operations.', now()->subMonths(1)->addDays(20)],
            [OpportunityStage::PROPOSAL, 'Proposal submitted for 15 inventory clerks.', now()->subMonth()],
            [OpportunityStage::NEGOTIATION, 'Negotiation on contract terms and rates.', now()->subWeeks(2)],
            [OpportunityStage::CONTRACT_PROCESSING, 'Terms finalized. Legal review in progress.', now()->subWeek()],
        ]);

        // Pacific Properties — PROPOSAL (ongoing client)
        $pacificOpp = Opportunity::create([
            'company_id' => $pacificProperties->id,
            'client_id' => $pacificProperties->client->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Construction Site Manpower',
            'description' => 'Provide general helpers for ongoing construction projects.',
            'stage' => OpportunityStage::PROPOSAL,
            'manpower_requirement' => 40,
            'estimated_contract_value' => 1200000.00,
            'expected_close_date' => now()->addMonths(4)->toDateString(),
        ]);

        $this->createStageHistories($pacificOpp, $juan->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Referral inquiry for construction site staffing.', now()->subMonths(2)],
            [OpportunityStage::DISCUSSION, 'Meeting held to discuss project timeline and needs.', now()->subMonths(1)->addDays(15)],
            [OpportunityStage::PROPOSAL, 'Proposal submitted for 40 construction site helpers.', now()->subMonth()],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Converted Lead Company (6)
        |--------------------------------------------------------------------------
        | Summit Corporate Solutions started as a lead and was converted to a
        | client after an opportunity was won. The lead's status history includes
        | a "converted" entry whose reason matches the opportunity win reason.
        |
        |   - Summit Corporate Solutions (CONVERTED): Won opportunity
        |--------------------------------------------------------------------------
        */

        $summitCorp = Company::create([
            'name' => 'Summit Corporate Solutions',
            'industry' => 'Business Services',
            'address' => 'Bonifacio Global City, Metro Manila',
            'phone' => '+63 917 876 5432',
            'email' => 'info@summitcorp.example',
            'website' => 'https://summitcorp.example',
        ]);

        Contact::create([
            'company_id' => $summitCorp->id,
            'first_name' => 'Olivia',
            'last_name' => 'Park',
            'title' => 'Finance Director',
            'email' => 'olivia.park@summitcorp.example',
            'phone' => '+63 919 876 5432',
            'is_primary' => true,
        ]);

        Contact::create([
            'company_id' => $summitCorp->id,
            'first_name' => 'Marcus',
            'last_name' => 'Lee',
            'title' => 'Operations Head',
            'email' => 'marcus.lee@summitcorp.example',
            'phone' => '+63 920 876 5432',
            'is_primary' => false,
        ]);

        $summitLead = Lead::create([
            'company_id' => $summitCorp->id,
            'assigned_to_id' => $juan->id,
            'source' => 'Referral',
            'status' => LeadStatus::CONVERTED,
            'notes' => 'Converted to client after opportunity was won.',
        ]);

        $summitClient = Client::create([
            'company_id' => $summitCorp->id,
            'lead_id' => $summitLead->id,
            'assigned_to_id' => $juan->id,
            'status' => ClientStatus::ACTIVE,
            'client_since' => now()->subMonths(2)->toDateString(),
            'notes' => 'Converted from lead after winning corporate staffing contract.',
        ]);

        // Summit Corporate Solutions surveys
        ClientSurvey::create([
            'client_id' => $summitClient->id,
            'token' => 'srv_summit_001',
            'status' => 'completed',
            'responses' => [
                ['question_id' => 'q1', 'score' => 3],
                ['question_id' => 'q2', 'score' => 4],
                ['question_id' => 'q3', 'score' => 3],
                ['question_id' => 'q4', 'score' => 4],
                ['question_id' => 'q5', 'score' => 3],
            ],
            'average_score' => 3.4,
            'completed_at' => now()->subDays(60),
        ]);

        ClientSurvey::create([
            'client_id' => $summitClient->id,
            'token' => 'srv_summit_002',
            'status' => 'completed',
            'responses' => [
                ['question_id' => 'q1', 'score' => 4],
                ['question_id' => 'q2', 'score' => 4],
                ['question_id' => 'q3', 'score' => 4],
                ['question_id' => 'q4', 'score' => 4],
                ['question_id' => 'q5', 'score' => 4],
            ],
            'average_score' => 4.0,
            'completed_at' => now()->subDays(20),
        ]);

        $summitWinReason = 'Contract signed and fully executed. Client confirmed satisfaction with pilot deployment.';

        $summitOpp = Opportunity::create([
            'company_id' => $summitCorp->id,
            'lead_id' => $summitLead->id,
            'client_id' => $summitClient->id,
            'assigned_to_id' => $juan->id,
            'title' => 'Corporate Office Staffing',
            'description' => 'Supply 40 general office staff for corporate headquarters.',
            'stage' => OpportunityStage::WON,
            'manpower_requirement' => 40,
            'estimated_contract_value' => 2400000.00,
            'expected_close_date' => now()->subMonths(2)->toDateString(),
        ]);

        $this->createStageHistories($summitOpp, $juan->id, [
            [OpportunityStage::INITIAL_CONTACT, 'Referral introduced us to Summit Corporate.', now()->subMonths(5)],
            [OpportunityStage::DISCUSSION, 'Initial requirements gathering session with finance and operations directors.', now()->subMonths(4)],
            [OpportunityStage::PROPOSAL, 'Formal proposal submitted for 40 general office staff.', now()->subMonths(3)->addDays(15)],
            [OpportunityStage::NEGOTIATION, 'Client requested adjustments to staffing model and rates.', now()->subMonths(3)],
            [OpportunityStage::CONTRACT_PROCESSING, 'Terms agreed upon. Moving to contract drafting.', now()->subMonths(2)->addDays(10)],
            [OpportunityStage::WON, $summitWinReason, now()->subMonths(2)],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Lead Status Histories
        |--------------------------------------------------------------------------
        */

        $this->createStatusHistories($abcLead, $maria->id, [
            [LeadStatus::NEW, 'Initial contact made via referral from existing client.', now()->subDays(30)],
            [LeadStatus::QUALIFIED, 'Follow-up meeting completed with operations manager.', now()->subDays(20)],
        ]);

        $this->createStatusHistories($primeLead, $juan->id, [
            [LeadStatus::NEW, 'Inquiry received from warehouse operations manager.', now()->subDays(35)],
        ]);

        $this->createStatusHistories($goldenLead, $maria->id, [
            [LeadStatus::NEW, 'Initial contact made via cold outreach on LinkedIn.', now()->subDays(15)],
            [LeadStatus::QUALIFIED, 'HR confirmed requirements for packaging line support.', now()->subDays(5)],
        ]);

        $this->createStatusHistories($summitLead, $juan->id, [
            [LeadStatus::NEW, 'Referral introduced us to Summit Corporate.', now()->subMonths(5)],
            [LeadStatus::QUALIFIED, 'Requirements gathering session completed with finance and operations directors.', now()->subMonths(4)],
            [LeadStatus::CONVERTED, $summitWinReason, now()->subMonths(2)],
        ]);

        $this->createStatusHistories($metroLead, $juan->id, [
            [LeadStatus::NEW, 'Referral inquiry for holiday staffing needs.', now()->subMonths(9)],
            [LeadStatus::QUALIFIED, 'Requirements gathering session completed with procurement manager.', now()->subMonths(8)],
            [LeadStatus::CONVERTED, 'Contract signed and executed for seasonal store staffing deployment.', now()->subMonths(8)],
        ]);

        $this->createStatusHistories($pacificLead, $juan->id, [
            [LeadStatus::NEW, 'Referral inquiry for construction site staffing.', now()->subMonths(4)],
            [LeadStatus::QUALIFIED, 'Initial meeting held with administrative manager.', now()->subMonths(4)],
            [LeadStatus::CONVERTED, 'Construction site staffing contract awarded and executed.', now()->subMonths(3)],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Communications
        |--------------------------------------------------------------------------
        */

        $this->createCommunications($abcManufacturing, $abcLead, $maria->id, [
            [CommunicationType::EMAIL, CommunicationDirection::OUTGOING, 'Robert Santos', 'RFQ for Q4 2024 Staffing Requirements', 'Sent detailed RFQ for 120 production line staff across 3 shifts.', null, null, now()->subDays(30)],
            [CommunicationType::PHONE, CommunicationDirection::INCOMING, 'Robert Santos', null, 'Called to follow up on RFQ. Interested in visiting our facility next week.', 18, null, now()->subDays(29)],
            [CommunicationType::MEETING, CommunicationDirection::OUTGOING, 'Robert Santos', 'Facility Visit Coordination', 'Scheduled visit to manufacturing plant. Discussing logistics for 50 production workers.', 30, now()->subDays(25), now()->subDays(26)],
        ]);

        $this->createCommunications($primeLogistics, $primeLead, $juan->id, [
            [CommunicationType::MEETING, CommunicationDirection::OUTGOING, 'Sarah Chen', 'Initial Discovery Call', '30-minute Zoom call to discuss warehouse staffing needs for peak season.', 30, now()->subDays(35), now()->subDays(35)],
            [CommunicationType::EMAIL, CommunicationDirection::INCOMING, 'Sarah Chen', 'Proposal Feedback', "Thanks for the proposal. We'd like to move forward but need to adjust scope for night shifts.", null, null, now()->subDays(30)],
        ]);

        $this->createCommunications($goldenFoods, $goldenLead, $maria->id, [
            [CommunicationType::TEXT, CommunicationDirection::OUTGOING, 'Daniel Torres', null, "Confirm tomorrow's interview schedule for night shift supervisor role.", null, null, now()->subDays(15)],
        ]);

        $this->createCommunications($metroRetail, $metroLead, $juan->id, [
            [CommunicationType::VIDEO, CommunicationDirection::INCOMING, 'Patricia Garcia', 'Seasonal Staffing Plan Review', 'Request a revised quote for 50 seasonal staff across Makati branches.', 45, now()->subDays(10), now()->subDays(10)],
            [CommunicationType::IN_PERSON, CommunicationDirection::OUTGOING, 'Patricia Garcia', null, 'Visited Makati branch to discuss on-site uniform fitting and orientation logistics.', 90, now()->subDays(7), now()->subDays(8)],
        ]);

        $this->createCommunications($pacificProperties, $pacificLead, $juan->id, [
            [CommunicationType::EMAIL, CommunicationDirection::OUTGOING, 'Sophia Mendoza', 'Site Visit Confirmation — Cebu Office', 'Confirmed site visit for 10 security personnel deployment at Cebu IT Park.', null, null, now()->subDays(12)],
        ]);

        $this->createCommunications($summitCorp, $summitLead, $juan->id, [
            [CommunicationType::PHONE, CommunicationDirection::OUTGOING, 'Olivia Park', null, 'Final payment confirmation for 40 general office staff deployment.', 12, null, now()->subDays(5)],
            [CommunicationType::MEETING, CommunicationDirection::INCOMING, 'Olivia Park', 'Quarterly Review Meeting Request', 'Requested Q3 review meeting to discuss scope expansion to Makati office.', null, now()->subDays(2), now()->subDays(1)],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Follow-up Reminders
        |--------------------------------------------------------------------------
        */

        $this->createReminders($abcManufacturing, $abcLead->id, [
            ['Follow up on RFQ response', 'Robert Santos requested a callback regarding the production staff RFQ sent last week.', now()->subDays(2), ReminderPriority::HIGH, false, null, 'Maria Santos'],
            ['Send updated proposal for 50 production workers', 'Client wants revised pricing for shift differentials.', now()->addDays(1), ReminderPriority::HIGH, false, null, 'Maria Santos'],
            ['Schedule facility tour', 'Organize a plant visit for the client next week.', now()->addDays(3), ReminderPriority::MEDIUM, false, null, 'Maria Santos'],
        ]);

        $this->createReminders($primeLogistics, $primeLead->id, [
            ['Confirm warehouse shift requirements', 'Client needs clarification on night shift coverage for 30 warehouse associates.', now()->subDays(1), ReminderPriority::MEDIUM, false, null, 'Juan Dela Cruz'],
            ['Send final proposal for peak season staffing', 'Proposal for 30 warehouse associates — follow up on negotiation feedback.', now()->addDays(2), ReminderPriority::HIGH, false, null, 'Juan Dela Cruz'],
        ]);

        $this->createReminders($goldenFoods, $goldenLead->id, [
            ['Follow up on packaging line quote', 'Client requested a callback on the packaging line helpers quote.', now()->subDays(3), ReminderPriority::MEDIUM, false, null, 'Maria Santos'],
        ]);

        $this->createReminders($metroRetail, $metroLead->id, [
            ['Renewal discussion for seasonal contract', 'Discuss extending seasonal staffing beyond January.', now()->addMonth(), ReminderPriority::MEDIUM, true, now()->subDays(30), 'Juan Dela Cruz'],
            ['Inventory staffing kickoff', 'Begin deployment of 15 inventory clerks for Q1 cycle count.', now()->addDays(5), ReminderPriority::HIGH, true, now()->subDays(15), 'Juan Dela Cruz'],
        ]);

        $this->createReminders($pacificProperties, $pacificLead->id, [
            ['Site safety briefing coordination', 'Schedule mandatory safety orientation for construction site helpers.', now()->addDays(4), ReminderPriority::MEDIUM, true, now()->subDays(10), 'Juan Dela Cruz'],
            ['Contract extension review', 'Review terms for extending construction site manpower beyond initial period.', now()->addWeeks(2), ReminderPriority::LOW, true, now()->subDays(5), 'Juan Dela Cruz'],
            ['Follow up on previous meeting notes', 'Send action items from last week\'s project alignment meeting.', now()->subDay(), ReminderPriority::LOW, true, now()->subHours(12), 'Maria Santos'],
        ]);

        $this->createReminders($summitCorp, $summitLead->id, [
            ['Q3 review meeting', 'Prepare quarterly review slides for scope expansion to Makati office.', now()->addDays(3), ReminderPriority::HIGH, true, now()->subDays(7), 'Juan Dela Cruz'],
            ['Payment confirmation follow-up', 'Follow up on Q3 payment status for the 40 general office staff contract.', now()->addDays(1), ReminderPriority::MEDIUM, true, now()->subDays(3), 'Juan Dela Cruz'],
        ]);
    }

    private function createCommunications(
        Company $company,
        Lead $lead,
        int $userId,
        array $communications
    ): void {
        foreach ($communications as $comm) {
            [$type, $direction, $contactName, $subject, $notes, $durationMinutes, $scheduledAt, $createdAt] = $comm;

            $contact = $company->contacts()
                ->whereRaw(
                    "CONCAT(first_name, ' ', last_name) = ?",
                    [$contactName]
                )
                ->first();

            Communication::create([
                'company_id' => $company->id,
                'lead_id' => $lead->id,
                'user_id' => $userId,
                'contact_id' => $contact?->id,
                'type' => $type,
                'direction' => $direction,
                'subject' => $subject,
                'notes' => $notes,
                'duration_minutes' => $durationMinutes,
                'scheduled_at' => $scheduledAt,
                'created_at' => $createdAt,
            ]);
        }
    }

    private function createStageHistories(
        Opportunity $opportunity,
        int $userId,
        array $histories
    ): void {
        $previousStage = null;

        foreach ($histories as [$stage, $reason, $createdAt]) {
            StageHistory::create([
                'opportunity_id' => $opportunity->id,
                'user_id' => $userId,
                'from_stage' => $previousStage,
                'to_stage' => $stage->value,
                'reason' => $reason,
                'created_at' => $createdAt,
            ]);

            $previousStage = $stage->value;
        }
    }

    private function createStatusHistories(
        Lead $lead,
        int $userId,
        array $histories
    ): void {
        $previousStatus = null;

        foreach ($histories as [$status, $reason, $createdAt]) {
            StatusHistory::create([
                'lead_id' => $lead->id,
                'user_id' => $userId,
                'from_status' => $previousStatus,
                'to_status' => $status->value,
                'reason' => $reason,
                'created_at' => $createdAt,
            ]);

            $previousStatus = $status->value;
        }
    }

    private function createReminders(
        Company $company,
        int $leadId,
        array $reminders
    ): void {
        foreach ($reminders as $reminder) {
            [
                $title,
                $description,
                $dueDate,
                $priority,
                $isCompleted,
                $completedAt,
                $assignedToName,
            ] = $reminder;

            Reminder::create([
                'company_id' => $company->id,
                'related_to_type' => 'lead',
                'related_to_id' => $leadId,
                'title' => $title,
                'description' => $description,
                'due_date' => $dueDate,
                'priority' => $priority,
                'is_completed' => $isCompleted,
                'completed_at' => $completedAt,
                'assigned_to_name' => $assignedToName,
                'created_at' => now()->subDays(5),
            ]);
        }
    }
}
