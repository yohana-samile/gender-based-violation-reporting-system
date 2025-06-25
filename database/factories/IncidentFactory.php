<?php
namespace Database\Factories;

use App\Models\Incident;
use App\Models\Status;
use App\Models\System\Code;
use App\Models\System\CodeValue;
use App\Models\System\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IncidentFactory extends Factory
{
    protected $model = Incident::class;

    public function definition()
    {
        $codeId = Code::query()->where('name', 'Case Type')->value('id');
        $types = CodeValue::query()->where('code_id', $codeId)->pluck('name')->toArray();
        $locations = District::query()->pluck('name')->toArray();

        return [
            'reporter_id' => 1,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'occurred_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'location' => $this->faker->randomElement($locations) ,
            'type' => $this->faker->randomElement($types),
            'is_anonymous' => $this->faker->boolean(20),
            'uid' => Str::uuid()
        ];
    }

    public function configure()
    {
        $vulnerabilityCodeId = Code::query()->where('name', 'Case Vulnerability')->value('id');
        $vulnerabilities = CodeValue::query()->where('code_id', $vulnerabilityCodeId)->pluck('name')->toArray();

        $genderCodeId = Code::query()->where('name', 'Gender')->value('id');
        $gender = CodeValue::query()->where('code_id', $genderCodeId)->pluck('name')->toArray();

        return $this->afterMaking(function (Incident $incident) {
            $incident->status = Status::where('slug', 'reported')->value('slug') ?? 'reported';
        })->afterCreating(function (Incident $incident) use ($gender, $vulnerabilities) {
            DB::transaction(function () use ($gender, $vulnerabilities, $incident) {
                $victimCount = $this->faker->numberBetween(1, 3);
                $victims = [];

                for ($i = 0; $i < $victimCount; $i++) {
                    $victims[] = [
                        'name' => $incident->is_anonymous ? null : $this->faker->name,
                        'gender' => $this->faker->randomElement($gender),
                        'age' => $this->faker->numberBetween(5, 80),
                        'contact_number' => $this->faker->phoneNumber,
                        'contact_email' => $this->faker->safeEmail,
                        'address' => $this->faker->address,
                        'vulnerability' => $this->faker->randomElement($vulnerabilities),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                $incident->victims()->createMany($victims);

                // 70% chance to have perpetrators
                if ($this->faker->boolean(70)) {
                    $perpetratorCount = $this->faker->numberBetween(1, 2);
                    $perpetrators = [];

                    for ($i = 0; $i < $perpetratorCount; $i++) {
                        $perpetrators[] = [
                            'name' => $this->faker->optional(0.7)->name,
                            'gender' => $this->faker->randomElement($gender),
                            'age' => $this->faker->numberBetween(18, 70),
                            'relationship_to_victim' => $this->faker->randomElement([
                                'family_member',
                                'caregiver',
                                'stranger',
                                'acquaintance'
                            ]),
                            'description' => $this->faker->optional()->paragraph,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    $incident->perpetrators()->createMany($perpetrators);
                }

                // 50% chance to have evidence (simulating file upload)
                if ($this->faker->boolean(50)) {
                    $fileTypes = [
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'pdf' => 'application/pdf',
                        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'mp4' => 'video/mp4',
                        'mp3' => 'audio/mpeg',
                        'txt' => 'text/plain'
                    ];

                    Storage::disk('public')->makeDirectory('evidence');

                    foreach ($fileTypes as $fileType => $mimeType) {
                        try {
                            $fakeFileName = 'evidence_'.$incident->id.'_'.strtoupper($fileType).'_'.uniqid().'.'.$fileType;
                            $fakePath = 'evidence/'.$fakeFileName;
                            $currentDate = now()->format('Y-m-d H:i:s');
                            $caseDetails = [
                                'Case ID' => $incident->id,
                                'Title' => $incident->title,
                                'Date' => $currentDate,
                                'Description' => $this->faker->sentence
                            ];

                            switch ($fileType) {
                                case 'jpg':
                                case 'png':
                                    $fontPaths = [
                                        resource_path('fonts/arial.ttf'),
                                        resource_path('fonts/Roboto-Regular.ttf'),
                                        base_path('vendor/laravel/framework/src/Illuminate/Console/fonts/OpenSans-Regular.ttf'),
                                        null
                                    ];
                                    $image = imagecreatetruecolor(800, 600);
                                    $bgColor = imagecolorallocate($image,
                                        $this->faker->numberBetween(200, 255),
                                        $this->faker->numberBetween(200, 255),
                                        $this->faker->numberBetween(200, 255)
                                    );
                                    imagefill($image, 0, 0, $bgColor);

                                    $textColor = imagecolorallocate($image, 0, 0, 0);

                                    $y = 50;
                                    foreach ($fontPaths as $fontPath) {
                                        try {
                                            foreach ($caseDetails as $label => $value) {
                                                imagettftext($image, 14, 0, 50, $y, $textColor, $fontPath, "$label: $value");
                                                $y += 30;
                                            }
                                            break;
                                        } catch (\Exception $e) {
                                            $y = 50;
                                            continue;
                                        }
                                    }

                                    if ($y == 50) {
                                        foreach ($caseDetails as $label => $value) {
                                            imagestring($image, 5, 50, $y, "$label: $value", $textColor);
                                            $y += 30;
                                        }
                                    }

                                    $tempFile = tempnam(sys_get_temp_dir(), 'img').'.'.$fileType;
                                    if ($fileType === 'jpg') {
                                        imagejpeg($image, $tempFile, 90);
                                    } else {
                                        imagepng($image, $tempFile);
                                    }
                                    Storage::disk('public')->put($fakePath, file_get_contents($tempFile));
                                    unlink($tempFile);
                                    imagedestroy($image);
                                    break;

                                case 'pdf':
                                    // Generate PDF with case details
                                    $pdfContent = <<<PDF
%PDF-1.4
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
<< /Type /Pages /Kids [3 0 R] /Count 1 >>
endobj
3 0 obj
<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R >>
endobj
4 0 obj
<< /Length 200 >>
stream
BT /F1 16 Tf 72 750 Td (EVIDENCE DOCUMENT - PDF) Tj ET
BT /F1 12 Tf 72 720 Td (Case ID: {$incident->id}) Tj ET
BT /F1 12 Tf 72 700 Td (Title: {$incident->title}) Tj ET
BT /F1 12 Tf 72 680 Td (Date: {$currentDate}) Tj ET
BT /F1 12 Tf 72 660 Td (Description: {$this->faker->paragraph(2)}) Tj ET
BT /F1 10 Tf 72 600 Td (This is an automatically generated PDF evidence document) Tj ET
endstream
endobj
xref
0 5
0000000000 65535 f
0000000010 00000 n
0000000060 00000 n
0000000116 00000 n
0000000225 00000 n
trailer
<< /Size 5 /Root 1 0 R >>
startxref
500
%%EOF
PDF;
                                    Storage::disk('public')->put($fakePath, $pdfContent);
                                    break;

                                case 'docx':
                                    // Generate Word document with case details
                                    $docContent = <<<DOCX
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>
    <w:p>
      <w:r>
        <w:t>EVIDENCE DOCUMENT - DOCX</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>Case ID: {$incident->id}</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>Title: {$incident->title}</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>Date: {$currentDate}</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>Description:</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>{$this->faker->paragraph(3)}</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:r>
        <w:t>This is an automatically generated evidence document.</w:t>
      </w:r>
    </w:p>
  </w:body>
</w:document>
DOCX;
                                    Storage::disk('public')->put($fakePath, $docContent);
                                    break;

                                case 'mp4':
                                    // Generate video file with metadata
                                    $videoContent = hex2bin('00000018667479706d703432000000006d7034326d703431') .
                                        "VIDEO METADATA\n".
                                        "Title: Evidence for Case #{$incident->id}\n".
                                        "Description: {$incident->title}\n".
                                        "Date: {$currentDate}\n".
                                        "Duration: 00:00:00\n".
                                        str_repeat("\0", 2048); // Padding
                                    Storage::disk('public')->put($fakePath, $videoContent);
                                    break;

                                case 'mp3':
                                    // Generate audio file with ID3 tags
                                    $mp3Content = hex2bin('49443303000000000000') . // ID3 header
                                        "TITLE=Case Evidence Audio\n".
                                        "ARTIST=GBV System\n".
                                        "ALBUM=Case #{$incident->id}\n".
                                        "DATE=".date('Y')."\n".
                                        "COMMENT={$incident->title}\n".
                                        str_repeat("\0", 2048); // Padding
                                    Storage::disk('public')->put($fakePath, $mp3Content);
                                    break;

                                case 'txt':
                                    // Generate text file with case details
                                    $textContent = "EVIDENCE DOCUMENT - TXT\n\n".
                                        "Case ID: {$incident->id}\n".
                                        "Title: {$incident->title}\n".
                                        "Date: {$currentDate}\n\n".
                                        "Description:\n".
                                        "{$this->faker->paragraph(3)}\n\n".
                                        "This is an automatically generated text evidence document.\n".
                                        "Generated by GBV System on {$currentDate}";
                                    Storage::disk('public')->put($fakePath, $textContent);
                                    break;
                            }

                            $incident->evidence()->create([
                                'file_path' => $fakePath,
                                'file_type' => $fileType,
                                'mime_type' => $mimeType,
                                'description' => "Evidence document (".strtoupper($fileType).") for Case #{$incident->id}",
                                'created_at' => now(),
                                'updated_at' => now(),
                                'file_size' => Storage::disk('public')->size($fakePath),
                                'original_name' => "evidence_{$incident->id}_".strtoupper($fileType).".{$fileType}",
                            ]);

                        } catch (\Exception $e) {
                            logger()->error("Failed to generate {$fileType} evidence: ".$e->getMessage());
                            continue;
                        }
                    }
                }
            });
        });
    }
}
