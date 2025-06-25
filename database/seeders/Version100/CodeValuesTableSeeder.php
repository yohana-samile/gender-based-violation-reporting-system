<?php

use App\Models\System\Code;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;
use App\Models\System\CodeValue;

class CodeValuesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys("code_values");
        $this->delete('code_values');

        $allCodeValues = [
            'User Logs' => [
                ['reference' => 'ULLGI', 'name' => 'Log In'],
                ['reference' => 'ULLGO', 'name' => 'Log Out'],
                ['reference' => 'ULFLI', 'name' => 'Failed Log In'],
                ['reference' => 'ULPRS', 'name' => 'Password Reset'],
                ['reference' => 'ULULC', 'name' => 'User Lockout'],
            ],
            'Auth User Type' => [
                ['reference' => 'USER000', 'name' => 'Super Admin'],
                ['reference' => 'USER001', 'name' => 'Case Worker'],
                ['reference' => 'USER002', 'name' => 'Reporter'],
                ['reference' => 'USER003', 'name' => 'Law Enforcement'],
            ],
            'Gender' => [
                ['reference' => 'GENDER01', 'name' => 'Male', 'is_system_defined' => 0],
                ['reference' => 'GENDER02', 'name' => 'Female', 'is_system_defined' => 0],
            ],
            'Marital Status' => [
                ['reference' => 'MARITAL01', 'name' => 'Married', 'is_system_defined' => 0],
                ['reference' => 'MARITAL02', 'name' => 'Single', 'is_system_defined' => 0],
                ['reference' => 'MARITAL03', 'name' => 'Divorce', 'is_system_defined' => 0],
            ],
            /* same to case status change */
            'Case Status' => [
                ['reference' => 'CASE01', 'name' => 'reported', 'is_system_defined' => 1],
                ['reference' => 'CASE03', 'name' => 'under_investigation', 'is_system_defined' => 1],
                ['reference' => 'CASE04', 'name' => 'resolved', 'is_system_defined' => 1],
                ['reference' => 'CASE05', 'name' => 'closed', 'is_system_defined' => 1],
                ['reference' => 'CASE06', 'name' => 'null', 'is_system_defined' => 1],
            ],
            'Case Vulnerability' => [
                ['reference' => 'VUL01', 'name' => 'child', 'is_system_defined' => 0],
                ['reference' => 'VUL02', 'name' => 'disabled', 'is_system_defined' => 0],
                ['reference' => 'VUL03', 'name' => 'elderly', 'is_system_defined' => 0],
                ['reference' => 'VUL04', 'name' => 'refugee', 'is_system_defined' => 0],
                ['reference' => 'VUL05', 'name' => 'none', 'is_system_defined' => 0],
                ['reference' => 'VUL06', 'name' => 'other', 'is_system_defined' => 0],
            ],
            'Case Type' => [
                ['reference' => 'TYPE01', 'name' => 'Legal', 'is_system_defined' => 0],
                ['reference' => 'TYPE02', 'name' => 'Medical', 'is_system_defined' => 0],
                ['reference' => 'TYPE03', 'name' => 'Counseling', 'is_system_defined' => 0],
                ['reference' => 'TYPE04', 'name' => 'Shelter', 'is_system_defined' => 0],
                ['reference' => 'TYPE05', 'name' => 'Law Enforcement', 'is_system_defined' => 0],
                ['reference' => 'TYPE06', 'name' => 'Sexual violence', 'is_system_defined' => 0],
                ['reference' => 'TYPE07', 'name' => 'Emotional abuse', 'is_system_defined' => 0],
                ['reference' => 'TYPE08', 'name' => 'Economic abuse', 'is_system_defined' => 0],
                ['reference' => 'TYPE09', 'name' => 'Child marriage', 'is_system_defined' => 0],
                ['reference' => 'TYPE10', 'name' => 'Female genital mutilation', 'is_system_defined' => 0],
                ['reference' => 'TYPE11', 'name' => 'Trafficking', 'is_system_defined' => 0],
                ['reference' => 'TYPE12', 'name' => 'Physical violence', 'is_system_defined' => 0],
                ['reference' => 'TYPE13', 'name' => 'Other', 'is_system_defined' => 0],
            ],
        ];

        foreach ($allCodeValues as $codeName => $values) {
            $codeId = Code::query()->where('name', $codeName)->value('id');
            $sort = 1;

            foreach ($values as $value) {
                CodeValue::withTrashed()->updateOrCreate(
                    ['reference' => $value['reference']],
                    [
                        'code_id' => $codeId,
                        'name' => $value['name'],
                        'lang' => null,
                        'description' => '',
                        'sort' => $sort++,
                        'isactive' => $value['isactive'] ?? 1,
                        'is_system_defined' => $value['is_system_defined'] ?? 1,
                    ]
                );
            }
        }
        $this->enableForeignKeys("code_values");
    }
}
