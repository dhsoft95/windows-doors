<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'John Smith',
                'slug' => 'john-smith',
                'email' => 'john@simbadoors.co.tz',
                'bio' => 'John Smith is a security expert with over 15 years of experience in door and window security systems. He specializes in advising on high-security solutions for both residential and commercial properties.',
                'profile_image' => 'authors/john-smith.jpg',
                'website' => 'https://johnsecurity.com',
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/johnsmith',
                    'twitter' => 'https://twitter.com/johnsmith',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Wilson',
                'slug' => 'sarah-wilson',
                'email' => 'sarah@simbadoors.co.tz',
                'bio' => 'Sarah Wilson is an interior designer with a passion for creating harmonious spaces. She brings her expertise in door and window design to help clients achieve both functionality and aesthetic appeal.',
                'profile_image' => 'authors/sarah-wilson.jpg',
                'website' => 'https://sarahdesigns.com',
                'social_links' => json_encode([
                    'instagram' => 'https://instagram.com/sarahwilsondesign',
                    'pinterest' => 'https://pinterest.com/sarahwilson',
                ]),
                'is_active' => true,
            ],
            // Add firstOrCreate to prevent duplicates
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate(
                ['slug' => $author['slug']],
                $author
            );
        }
    }
}
