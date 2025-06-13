<?php
namespace Database\Factories;

use App\Models\Incident;
use App\Models\System\CodeValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IncidentFactory extends Factory
{
    protected $model = Incident::class;

    public function definition()
    {
        $types = ['physical_abuse', 'sexual_abuse', 'emotional_abuse', 'neglect', 'financial_abuse'];

        return [
            'reporter_id' => 1,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'occurred_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'location' => $this->faker->address,
            'type' => $this->faker->randomElement($types),
            'is_anonymous' => $this->faker->boolean(20),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Incident $incident) {
            $incident->status = CodeValue::where('reference', 'CASE01')->value('name') ?? 'reported';
        })->afterCreating(function (Incident $incident) {
            DB::transaction(function () use ($incident) {
                $victimCount = $this->faker->numberBetween(1, 3);
                $victims = [];

                for ($i = 0; $i < $victimCount; $i++) {
                    $victims[] = [
                        'name' => $incident->is_anonymous ? null : $this->faker->name,
                        'gender' => $this->faker->randomElement(['male', 'female', 'other']),
                        'age' => $this->faker->numberBetween(5, 80),
                        'contact_number' => $this->faker->phoneNumber,
                        'contact_email' => $this->faker->safeEmail,
                        'address' => $this->faker->address,
                        'vulnerability' => $this->faker->randomElement(['child', 'elderly', 'disabled', 'none']),
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
                            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
                            'age' => $this->faker->numberBetween(18, 70),
                            'relationship_to_victim' => $this->faker->randomElement([
                                'family_member',
                                'caregiver',
                                'stranger',
                                'acquaintance'
                            ]),
                            'description' => $this->faker->optional()->paragraph,
                        ];
                    }

                    $incident->perpetrators()->createMany($perpetrators);
                }

                // 50% chance to have evidence (simulating file upload)
                if ($this->faker->boolean(50)) {
                    $evidenceCount = $this->faker->numberBetween(1, 3);
                    $fileTypes = ['jpg', 'png', 'pdf', 'doc'];

                    for ($i = 0; $i < $evidenceCount; $i++) {
                        $fileType = $this->faker->randomElement($fileTypes);
                        $fakeFileName = 'evidence_' . uniqid() . '.' . $fileType;
                        $fakePath = 'evidence/' . $fakeFileName;

                        // Simulate file storage
                        Storage::disk('public')->put($fakePath, 'fake content');

                        $incident->evidence()->create([
                            'file_path' => $fakePath,
                            'file_type' => $fileType,
                            'description' => $this->faker->optional()->sentence,
                        ]);
                    }
                }
            });
        });
    }
}
