<?php

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\LeadStatus;
use App\Enums\UserRole;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
    }
}
