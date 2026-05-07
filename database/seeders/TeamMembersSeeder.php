<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Alex Johnson',
                'position' => 'CEO & Founder',
                'bio' => 'Visionary leader with 15+ years in digital innovation and entrepreneurship. Passionate about empowering businesses through technology.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Chen',
                'position' => 'CTO',
                'bio' => 'Tech innovator specializing in scalable digital solutions and cloud architecture. Former tech lead at Fortune 500 companies.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Marcus Rodriguez',
                'position' => 'Head of Design',
                'bio' => 'Award-winning designer creating stunning digital experiences. Expert in UI/UX design and brand strategy with global recognition.',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}