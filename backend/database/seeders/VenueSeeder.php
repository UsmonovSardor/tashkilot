<?php

namespace Database\Seeders;

use App\Models\Venue;
use App\Models\VenueAmenity;
use App\Models\VenueAddon;
use App\Models\VenueSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    private array $venues = [
        [
            'name'        => 'The Obsidian Penthouse',
            'type'        => 'penthouse',
            'address'     => '47th Floor, Business Centre Tower, Amir Temur Avenue',
            'city'        => 'Tashkent',
            'lat'         => 41.2995,
            'lng'         => 69.2401,
            'capacity_min'=> 2,
            'capacity_max'=> 30,
            'base_hourly' => 1200.00,
            'base_half'   => 4500.00,
            'base_full'   => 8000.00,
            'cover'       => 'https://images.unsplash.com/photo-1606402179428-a57976d71fa4?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1200&q=90',
                'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?w=1200&q=90',
                'https://images.unsplash.com/photo-1601760561441-16420502c7e0?w=1200&q=90',
            ],
            'short_description' => 'Tashkent\'s highest private event space with 360° panoramic city views.',
            'description' => 'Perched on the 47th floor of Tashkent\'s most prestigious business tower, The Obsidian Penthouse offers an incomparable setting for intimate VIP dinners, private product launches, and exclusive corporate receptions. Floor-to-ceiling obsidian glass walls reveal a breathtaking 360° panorama of the Tian Shan mountain range at dawn and the city\'s glittering skyline after dark. The space features a bespoke Italian kitchen, a curated cellar of 200+ fine wines, and a dedicated butler service team. Helipad access available for arrivals requiring the ultimate statement of arrival.',
            'amenities'   => [
                ['name' => 'Private Helipad Access', 'icon' => 'helicopter'],
                ['name' => '360° City & Mountain Views', 'icon' => 'view'],
                ['name' => 'Bespoke Italian Kitchen', 'icon' => 'kitchen'],
                ['name' => 'Fine Wine Cellar (200+ labels)', 'icon' => 'wine'],
                ['name' => 'Dedicated Butler Team', 'icon' => 'butler'],
                ['name' => 'Starlink Ultra-Fast WiFi', 'icon' => 'wifi'],
                ['name' => 'Grand Piano (Steinway Model D)', 'icon' => 'music'],
                ['name' => 'Private Cinema Screen', 'icon' => 'cinema'],
            ],
            'addons' => [
                ['name' => 'Premium Catering by Noma-Trained Chef',   'desc' => '5-course degustation with wine pairing', 'price' => 450.00, 'type' => 'flat', 'per' => 'per_person'],
                ['name' => 'Fresh Floral Installation',               'desc' => 'Bespoke arrangement by top Tashkent florist', 'price' => 1200.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Live Jazz Quartet',                       'desc' => '3-hour performance, international repertoire', 'price' => 2400.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Private Sommelier for 3 Hours',           'desc' => 'Expert wine service and pairing guidance', 'price' => 600.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Professional Photography & Videography',  'desc' => '4-hour editorial shoot, same-day delivery', 'price' => 1800.00, 'type' => 'flat', 'per' => 'flat'],
            ],
        ],
        [
            'name'        => 'Velvet Rooftop Terrace',
            'type'        => 'rooftop_terrace',
            'address'     => 'Chorsu Arts District, 12 Navoi Street',
            'city'        => 'Tashkent',
            'lat'         => 41.3012,
            'lng'         => 69.2258,
            'capacity_min'=> 10,
            'capacity_max'=> 120,
            'base_hourly' => 800.00,
            'base_half'   => 3000.00,
            'base_full'   => 5500.00,
            'cover'       => 'https://images.unsplash.com/photo-1534430480872-3498386e7856?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=1200&q=90',
                'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=1200&q=90',
                'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=1200&q=90',
            ],
            'short_description' => 'Open-air luxury rooftop in the heart of the arts district, perfect for gala evenings.',
            'description' => 'Velvet Rooftop Terrace sits above Tashkent\'s vibrant arts quarter, offering a sophisticated outdoor canvas for gala evenings, cocktail receptions, and exclusive brand activations. Retractable weather-proof canopy allows year-round operation. The terrace features a bespoke neon art installation by a renowned Uzbek contemporary artist, an open-flame grill station, three premium bar pods, and custom-built lounging islands with plush outdoor furniture. The space accommodates up to 120 guests for standing receptions or 60 for seated dinners with theatrical buffet service.',
            'amenities'   => [
                ['name' => 'Retractable Weather Canopy', 'icon' => 'canopy'],
                ['name' => 'Custom Neon Art Installation', 'icon' => 'art'],
                ['name' => 'Three Premium Bar Pods', 'icon' => 'bar'],
                ['name' => 'Open-Flame Grill Station', 'icon' => 'grill'],
                ['name' => 'Professional Sound & Light Rig', 'icon' => 'sound'],
                ['name' => 'Panoramic Tashkent Skyline Views', 'icon' => 'view'],
                ['name' => 'Heated Outdoor Lounging Islands', 'icon' => 'lounge'],
            ],
            'addons' => [
                ['name' => 'Premium Open Bar (4 hours)',            'desc' => 'Champagne, spirits, mocktails, baristas', 'price' => 180.00, 'type' => 'flat', 'per' => 'per_person'],
                ['name' => 'International DJ (4 hours)',            'desc' => 'Berlin/Dubai club circuit resident DJ', 'price' => 3200.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Candle & Floral Table Styling',         'desc' => 'White & gold luxury table dress', 'price' => 2800.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Fireworks Display (5 min)',              'desc' => 'Licensed pyrotechnic show', 'price' => 4500.00, 'type' => 'flat', 'per' => 'flat'],
            ],
        ],
        [
            'name'        => 'The Sapphire Boardroom',
            'type'        => 'boardroom',
            'address'     => 'Tashkent International Business Centre, Block A, Level 18',
            'city'        => 'Tashkent',
            'lat'         => 41.2980,
            'lng'         => 69.2450,
            'capacity_min'=> 4,
            'capacity_max'=> 20,
            'base_hourly' => 450.00,
            'base_half'   => 1600.00,
            'base_full'   => 2800.00,
            'cover'       => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=1200&q=90',
                'https://images.unsplash.com/photo-1517502884422-41eaead166d4?w=1200&q=90',
                'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1200&q=90',
            ],
            'short_description' => 'Discreet, ultra-equipped private boardroom for power meetings and deal closings.',
            'description' => 'The Sapphire Boardroom is the premier choice for deal closings, investor presentations, and sensitive strategic sessions in Central Asia. Shielded by military-grade RF signal blocking for zero electronic eavesdropping, it seats 20 in executive leather chairs around a hand-crafted Italian marble conference table. The room features a dual 98" 8K display wall, a secure video conferencing suite certified to NATO STANAG standards, and a dedicated pre-meeting lounge with premium catering service. All session materials are shredded on-site. NDAs and confidentiality agreements are a standard part of the booking.',
            'amenities'   => [
                ['name' => 'RF Signal Blocking (Zero Eavesdrop)', 'icon' => 'shield'],
                ['name' => 'Dual 98" 8K Display Wall', 'icon' => 'display'],
                ['name' => 'NATO-Grade Secure Video Conferencing', 'icon' => 'video'],
                ['name' => 'Italian Marble Conference Table', 'icon' => 'table'],
                ['name' => 'Pre-Meeting Executive Lounge', 'icon' => 'lounge'],
                ['name' => 'On-Site Document Shredding', 'icon' => 'security'],
                ['name' => 'Private Catering Service', 'icon' => 'catering'],
                ['name' => 'Bilingual Personal Assistant', 'icon' => 'assistant'],
            ],
            'addons' => [
                ['name' => 'Executive Catering (Continental)',     'desc' => 'Breakfast, lunch, or afternoon tea service', 'price' => 95.00, 'type' => 'flat', 'per' => 'per_person'],
                ['name' => 'Bilingual Legal Interpreter',          'desc' => 'English/Russian/Uzbek/Arabic', 'price' => 350.00, 'type' => 'flat', 'per' => 'per_hour'],
                ['name' => 'Secure Document Translation Service',  'desc' => 'Certified translations, 24h turnaround', 'price' => 200.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Corporate Photography',                'desc' => '2-hour headshot and meeting documentation', 'price' => 800.00, 'type' => 'flat', 'per' => 'flat'],
            ],
        ],
        [
            'name'        => 'Amber VIP Lounge — Tashkent International Airport',
            'type'        => 'vip_lounge',
            'address'     => 'Terminal A, VIP Level, Islam Karimov International Airport',
            'city'        => 'Tashkent',
            'lat'         => 41.2577,
            'lng'         => 69.2811,
            'capacity_min'=> 1,
            'capacity_max'=> 15,
            'base_hourly' => 380.00,
            'base_half'   => 1400.00,
            'base_full'   => 2500.00,
            'cover'       => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1551918120-9739cb430c6d?w=1200&q=90',
                'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?w=1200&q=90',
            ],
            'short_description' => 'The most exclusive arrivals & departures experience in Central Asia.',
            'description' => 'Amber VIP Lounge offers a world-class sanctuary for high-profile arrivals and departures at Islam Karimov International Airport. Exclusive airside access, a private immigration and customs clearance line, luxury vehicle airside tarmac handover, and a bespoke dining menu make this the definitive airport experience in Central Asia. The lounge features private sleeping suites, spa treatment rooms, a full business centre, and direct tarmac access for private jet and charter clients. Reserved parking for Rolls-Royce and Bentley fleet vehicles is adjacent to the terminal entrance.',
            'amenities'   => [
                ['name' => 'Private Immigration Fast-Track', 'icon' => 'passport'],
                ['name' => 'Tarmac Vehicle Handover', 'icon' => 'car'],
                ['name' => 'Private Sleeping Suite', 'icon' => 'bed'],
                ['name' => 'Spa Treatment Room', 'icon' => 'spa'],
                ['name' => 'Bespoke Fine Dining Menu', 'icon' => 'dining'],
                ['name' => 'Business Centre & Secure Printing', 'icon' => 'business'],
                ['name' => 'Premium Bar & Champagne Service', 'icon' => 'champagne'],
                ['name' => 'Private Jet Concierge', 'icon' => 'jet'],
            ],
            'addons' => [
                ['name' => 'Private Immigration Escort',  'desc' => 'Dedicated officer from aircraft to vehicle', 'price' => 600.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Spa Treatment (60 min)',       'desc' => 'Deep tissue, Swedish, or reflexology', 'price' => 280.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Champagne Welcome Package',    'desc' => 'Dom Pérignon and premium canapés', 'price' => 450.00, 'type' => 'flat', 'per' => 'flat'],
            ],
        ],
        [
            'name'        => 'Villa Bianca — Private Estate',
            'type'        => 'private_villa',
            'address'     => 'Mirabad District, Tashkent (Exact address upon confirmation)',
            'city'        => 'Tashkent',
            'lat'         => 41.3125,
            'lng'         => 69.2750,
            'capacity_min'=> 10,
            'capacity_max'=> 60,
            'base_hourly' => null,
            'base_half'   => 6000.00,
            'base_full'   => 10000.00,
            'cover'       => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1200&q=90',
                'https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?w=1200&q=90',
                'https://images.unsplash.com/photo-1544984243-ec57ea16fe25?w=1200&q=90',
                'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1200&q=90',
            ],
            'short_description' => 'Fully-staffed private estate with pool, garden theatre, and gourmet kitchen.',
            'description' => 'Villa Bianca is Tashkent\'s most coveted private estate venue — a 3,200sqm Italian-Renaissance-inspired residence surrounded by manicured English gardens. Available exclusively for private bookings, it features a 25m heated infinity pool, a garden amphitheatre seating 80, a professional catering kitchen, four en-suite guest apartments, and a dedicated house manager team of 12. The estate\'s location in Tashkent\'s most prestigious residential district ensures complete privacy. Security perimeter and CCTV are active 24/7. The estate has hosted royalty, international celebrities, and Fortune 100 boardroom retreats.',
            'amenities'   => [
                ['name' => '25m Heated Infinity Pool', 'icon' => 'pool'],
                ['name' => 'Garden Amphitheatre (80 seats)', 'icon' => 'theatre'],
                ['name' => 'Professional Catering Kitchen', 'icon' => 'kitchen'],
                ['name' => '4 En-Suite Guest Apartments', 'icon' => 'bedroom'],
                ['name' => 'House Manager Team (12 staff)', 'icon' => 'staff'],
                ['name' => '24/7 Security Perimeter & CCTV', 'icon' => 'security'],
                ['name' => 'Tennis Court & Spa Pavilion', 'icon' => 'tennis'],
                ['name' => 'Helicopter Landing Zone', 'icon' => 'helicopter'],
            ],
            'addons' => [
                ['name' => 'Gourmet Catering (Full Estate)',       'desc' => '6-course seated dinner for up to 60 guests', 'price' => 380.00, 'type' => 'flat', 'per' => 'per_person'],
                ['name' => 'Live Orchestra (4 hours)',              'desc' => '12-piece chamber orchestra, classical or contemporary', 'price' => 8500.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Floral & Decor Design Package',        'desc' => 'Full venue floristry and bespoke decor installation', 'price' => 5500.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Security Detail (Full Event)',          'desc' => '6 licensed close-protection officers', 'price' => 3600.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Pool Party Entertainment Package',     'desc' => 'DJ, lighting, float styling, bar service', 'price' => 4200.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Overnight Guest Accommodation',        'desc' => '4 suites, next-day checkout included', 'price' => 2400.00, 'type' => 'flat', 'per' => 'flat'],
            ],
        ],
        [
            'name'        => 'The Platinum Gallery — Private Members Club',
            'type'        => 'vip_lounge',
            'address'     => 'Yakkasaray District, 88 Uzbekistan Street',
            'city'        => 'Tashkent',
            'lat'         => 41.2950,
            'lng'         => 69.2600,
            'capacity_min'=> 2,
            'capacity_max'=> 40,
            'base_hourly' => 650.00,
            'base_half'   => 2400.00,
            'base_full'   => 4200.00,
            'cover'       => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=1400&q=90',
            'images'      => [
                'https://images.unsplash.com/photo-1609220136736-443140cfeaa8?w=1200&q=90',
                'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=1200&q=90',
            ],
            'short_description' => 'Rotating fine art collection meets ultra-private members-only lounge.',
            'description' => 'The Platinum Gallery is a fusion of art institution and ultra-exclusive members club — an invitation-only space that blends curated rotating contemporary art exhibitions with impeccable private dining and lounge service. Membership walls feature works from Central Asian and international artists valued between $50K–$2M. The Gallery hosts quarterly private auction previews for members and their guests. A hidden speakeasy-style cocktail laboratory in the basement, managed by an award-winning mixologist, completes the experience. The only dress code: impeccably groomed.',
            'amenities'   => [
                ['name' => 'Rotating Fine Art Exhibition', 'icon' => 'art'],
                ['name' => 'Private Auction Preview Access', 'icon' => 'auction'],
                ['name' => 'Hidden Speakeasy Bar', 'icon' => 'bar'],
                ['name' => 'Award-Winning Mixologist On-Call', 'icon' => 'cocktail'],
                ['name' => 'Private Dining Alcoves (8 seats)', 'icon' => 'dining'],
                ['name' => 'Members-Only Cigar Salon', 'icon' => 'cigar'],
                ['name' => 'Concierge Art Advisory Service', 'icon' => 'advisory'],
            ],
            'addons' => [
                ['name' => 'Art Advisory Session (1 hour)',         'desc' => 'Private consultation with resident art advisor', 'price' => 500.00, 'type' => 'flat', 'per' => 'flat'],
                ['name' => 'Bespoke Cocktail Tasting Menu',        'desc' => '7-course cocktail pairing with seasonal ingredients', 'price' => 280.00, 'type' => 'flat', 'per' => 'per_person'],
                ['name' => 'Cigar Selection & Pairing',             'desc' => 'Davidoff & Cohiba with cognac pairing', 'price' => 350.00, 'type' => 'flat', 'per' => 'per_person'],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->venues as $v) {
            $venue = Venue::create([
                'name'              => $v['name'],
                'type'              => $v['type'],
                'description'       => $v['description'],
                'short_description' => $v['short_description'],
                'address'           => $v['address'],
                'city'              => $v['city'],
                'latitude'          => $v['lat'],
                'longitude'         => $v['lng'],
                'capacity_min'      => $v['capacity_min'],
                'capacity_max'      => $v['capacity_max'],
                'base_price_per_hour'  => $v['base_hourly'] ?? 0,
                'base_price_half_day'  => $v['base_half'],
                'base_price_full_day'  => $v['base_full'],
                'cover_image_url'   => $v['cover'],
                'images'            => $v['images'],
                'rating'            => round(4.85 + mt_rand(0, 15) / 100, 2),
                'total_reviews'     => rand(12, 45),
                'is_active'         => true,
                'is_featured'       => true,
            ]);

            foreach ($v['amenities'] as $amenity) {
                VenueAmenity::create([
                    'venue_id' => $venue->id,
                    'name'     => $amenity['name'],
                    'icon'     => $amenity['icon'],
                ]);
            }

            foreach ($v['addons'] as $addon) {
                VenueAddon::create([
                    'venue_id'     => $venue->id,
                    'name'         => $addon['name'],
                    'description'  => $addon['desc'],
                    'price'        => $addon['price'],
                    'pricing_type' => $addon['per'],
                    'is_active'    => true,
                ]);
            }

            // Generate 30 days of available slots
            $this->generateSlots($venue);
        }

        $this->command->info('✓ Seeded 6 luxury venues with amenities, add-ons, and 30-day slot availability');
    }

    private function generateSlots(Venue $venue): void
    {
        $slotTimes = [
            ['start' => '08:00', 'end' => '12:00'],
            ['start' => '12:00', 'end' => '16:00'],
            ['start' => '16:00', 'end' => '20:00'],
            ['start' => '20:00', 'end' => '00:00'],
        ];

        for ($day = 1; $day <= 30; $day++) {
            $date = Carbon::today()->addDays($day)->format('Y-m-d');

            foreach ($slotTimes as $slot) {
                // Mark ~25% of slots as already booked for realism
                $status = (rand(1, 100) <= 25) ? 'booked' : 'available';

                // Weekend premium pricing
                $dayOfWeek = Carbon::parse($date)->dayOfWeek;
                $priceMultiplier = in_array($dayOfWeek, [5, 6]) ? 1.35 : 1.0;
                $priceOverride = $venue->base_price_per_hour > 0
                    ? round($venue->base_price_per_hour * $priceMultiplier * 4, 2) // 4h block
                    : null;

                VenueSlot::create([
                    'venue_id'       => $venue->id,
                    'date'           => $date,
                    'start_time'     => $slot['start'],
                    'end_time'       => $slot['end'],
                    'status'         => $status,
                    'price_override' => $priceOverride,
                ]);
            }
        }
    }
}
