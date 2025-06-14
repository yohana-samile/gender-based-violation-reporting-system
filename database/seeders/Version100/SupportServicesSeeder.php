<?php

use App\Models\Incident;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupportServicesSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    public function run() {
        $this->delete('support_services');
        $services = [
            [
                'name' => 'Victim Support Helpline',
                'description' => '24/7 confidential support for victims of crime and traumatic events',
                'contact_number' => '0800 842 846',
                'contact_email' => 'help@victimsupport.org',
                'website' => 'https://www.victimsupport.org',
                'type' => 'crisis_support',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Domestic Violence Intervention Service',
                'description' => 'Specialized support for victims of domestic violence including emergency shelter',
                'contact_number' => '0800 456 111',
                'contact_email' => 'support@dvis.org',
                'website' => 'https://www.dvis.org',
                'type' => 'domestic_violence',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Child Protection Services',
                'description' => 'Immediate response for child abuse and neglect cases',
                'contact_number' => '0508 326 459',
                'contact_email' => 'childprotection@socialservices.gov',
                'website' => 'https://www.childprotection.gov',
                'type' => 'child_protection',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Elder Abuse Response',
                'description' => 'Dedicated helpline for reporting and supporting elder abuse cases',
                'contact_number' => '0800 32 668 65',
                'contact_email' => 'eldercare@protection.org',
                'website' => 'https://www.elderprotection.org',
                'type' => 'elder_care',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Sexual Violence Crisis Center',
                'description' => 'Confidential support and medical care for survivors of sexual violence',
                'contact_number' => '0800 88 33 00',
                'contact_email' => 'amina.gbv.com',
                'website' => 'https://www.sexualviolencehelp.org',
                'type' => 'sexual_violence',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Mental Health Emergency Team',
                'description' => 'Immediate mental health support for trauma victims',
                'contact_number' => '0800 800 717',
                'contact_email' => 'mhet@health.gov',
                'website' =>'amina.gbv.com',
                'type' => 'mental_health',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Legal Aid Services',
                'description' => 'Free legal assistance for victims seeking protection orders or justice',
                'contact_number' => '0800 2 LEGAL',
                'contact_email' => 'legalaid@justice.gov',
                'website' => 'https://www.legalaidvictims.org',
                'type' => 'legal',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Refugee Trauma Support',
                'description' => 'Specialized services for refugees and asylum seekers who experienced violence',
                'contact_number' => '0800 4 REFUGEE',
                'contact_email' => 'support@refugeetrauma.org',
                'website' => 'https://www.refugeetrauma.org',
                'type' => 'refugee_support',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Disability Abuse Helpline',
                'description' => 'Dedicated support for people with disabilities experiencing abuse',
                'contact_number' => '0800 15 10 15',
                'contact_email' => 'disabilityhelp@protection.org',
                'website' => 'https://www.disabilityprotection.org',
                'type' => 'disability_support',
                'uid' => Str::uuid(),
            ],
            [
                'name' => 'Financial Abuse Support',
                'description' => 'Assistance for victims of financial exploitation and fraud',
                'contact_number' => '0800 3 FINANCIAL',
                'contact_email' => 'financialhelp@abusesupport.org',
                'website' => 'https://www.financialabusesupport.org',
                'type' => 'financial_support',
                'uid' => Str::uuid(),
            ],
        ];

        DB::table('support_services')->insert($services);
    }
}
