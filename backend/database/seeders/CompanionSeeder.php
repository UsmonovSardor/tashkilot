<?php

namespace Database\Seeders;

use App\Models\Companion;
use App\Models\CompanionLanguage;
use App\Models\CompanionPhoto;
use App\Models\CompanionSkill;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanionSeeder extends Seeder
{
    /**
     * 18 elite companion profiles — 9 female, 9 male.
     * Portraits from Unsplash with professional, high-resolution IDs.
     */
    private array $companions = [
        // ─────────── FEMALE COMPANIONS ───────────
        [
            'email'     => 'sophia.marlowe@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Sophia',
            'last_name' => 'Marlowe',
            'age'       => 24,
            'nationality'=> 'British',
            'headline'  => 'International Business Etiquette & Luxury Lifestyle Expert',
            'full_bio'  => 'Educated at Oxford with a Master\'s in International Relations, Sophia has accompanied C-suite executives across 40+ countries. She specialises in navigating high-stakes corporate dinners, luxury property viewings, and black-tie galas with effortless grace. Fluent in three languages, she is equally at home on a private yacht in Monaco or in a Mayfair boardroom.',
            'hourly_rate'  => 380.00,
            'half_day_rate'=> 1200.00,
            'full_day_rate'=> 2200.00,
            'rating'    => 4.97,
            'event_types'=> ['corporate', 'gala', 'luxury_travel', 'diplomatic'],
            'languages' => [
                ['language' => 'English',  'proficiency' => 'native'],
                ['language' => 'French',   'proficiency' => 'fluent'],
                ['language' => 'Russian',  'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'International Business Etiquette', 'category' => 'business',  'description' => 'Protocol for C-suite and diplomatic dinners', 'years_experience' => 4],
                ['skill_name' => 'Fine Dining & Wine Pairing',       'category' => 'cultural',  'description' => 'WSET Level 3 certified sommelier', 'years_experience' => 3],
                ['skill_name' => 'Luxury Property Advisory',         'category' => 'business',  'description' => 'Accompanied HNWI on real estate tours across Europe', 'years_experience' => 2],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=800&q=90', 'is_primary' => false],
                ['url' => 'https://images.unsplash.com/photo-1488716820095-cbe80883c496?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'anastasia.volkov@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Anastasia',
            'last_name' => 'Volkov',
            'age'       => 26,
            'nationality'=> 'Russian',
            'headline'  => 'Art Connoisseur, Museum Curator & Cultural Ambassador',
            'full_bio'  => 'Anastasia holds a Fine Arts degree from the Hermitage Academy, St. Petersburg. She curates private art collection tours, attends international auction previews, and consults on contemporary art acquisitions for private collectors. Her deep knowledge of Russian and European art history makes her a rare companion for cultural events and gallery openings.',
            'hourly_rate'  => 320.00,
            'half_day_rate'=> 1050.00,
            'full_day_rate'=> 1900.00,
            'rating'    => 4.94,
            'event_types'=> ['cultural', 'art', 'social', 'luxury_travel'],
            'languages' => [
                ['language' => 'Russian',  'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'German',   'proficiency' => 'conversational'],
                ['language' => 'Italian',  'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Fine Art & Auction Advisory',     'category' => 'cultural',  'description' => 'Christie\'s and Sotheby\'s preview attendance', 'years_experience' => 5],
                ['skill_name' => 'Art Collection Curation',         'category' => 'cultural',  'description' => 'Private collection advisory for HNWI', 'years_experience' => 3],
                ['skill_name' => 'Classical Music & Opera',         'category' => 'cultural',  'description' => 'Expert guide for opera houses in 12 cities', 'years_experience' => 6],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'yuki.tanaka@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Yuki',
            'last_name' => 'Tanaka',
            'age'       => 23,
            'nationality'=> 'Japanese',
            'headline'  => 'Professional Translator & Cross-Cultural Business Liaison',
            'full_bio'  => 'A Tokyo University graduate in International Commerce, Yuki has served as an elite interpreter and cultural liaison for Fortune 500 executives across Asia-Pacific. She understands the nuances of Japanese, Korean, and Chinese business protocol with exceptional depth. Perfect for high-value deal closings, trade delegations, and exclusive Japanese dining experiences.',
            'hourly_rate'  => 350.00,
            'half_day_rate'=> 1100.00,
            'full_day_rate'=> 2000.00,
            'rating'    => 4.99,
            'event_types'=> ['corporate', 'diplomatic', 'luxury_travel', 'gala'],
            'languages' => [
                ['language' => 'Japanese',  'proficiency' => 'native'],
                ['language' => 'English',   'proficiency' => 'fluent'],
                ['language' => 'Mandarin',  'proficiency' => 'fluent'],
                ['language' => 'Korean',    'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Simultaneous Interpretation',     'category' => 'business',  'description' => 'Certified AIIC interpreter, English-Japanese-Mandarin', 'years_experience' => 4],
                ['skill_name' => 'Asian Business Protocol',         'category' => 'business',  'description' => 'Gifting rituals, formal introductions, negotiation etiquette', 'years_experience' => 4],
                ['skill_name' => 'Japanese Tea Ceremony Host',      'category' => 'cultural',  'description' => 'Traditional Chado practitioner for cultural immersions', 'years_experience' => 7],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1524502397800-2eeaad7c3fe5?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'isabella.fontaine@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Isabella',
            'last_name' => 'Fontaine',
            'age'       => 28,
            'nationality'=> 'French',
            'headline'  => 'Luxury Fashion Stylist & Haute Couture Expert',
            'full_bio'  => 'Isabella studied at École de la Chambre Syndicale de la Couture Parisienne and has styled private clients for Paris Fashion Week, Cannes Film Festival, and Monaco Grand Prix. She assists clients in building bespoke wardrobes, advises on auction-house jewellery, and accompanies fashion week front rows. A refined eye combined with unmatched discretion.',
            'hourly_rate'  => 290.00,
            'half_day_rate'=> 950.00,
            'full_day_rate'=> 1700.00,
            'rating'    => 4.92,
            'event_types'=> ['fashion', 'social', 'gala', 'luxury_travel'],
            'languages' => [
                ['language' => 'French',   'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'Italian',  'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Haute Couture & Personal Styling',  'category' => 'creative', 'description' => 'Maison access: Chanel, Dior, Hermès', 'years_experience' => 6],
                ['skill_name' => 'Jewellery & Watch Advisory',        'category' => 'business', 'description' => 'Auction preview guidance for fine timepieces', 'years_experience' => 4],
                ['skill_name' => 'Event Red Carpet Protocol',         'category' => 'social',   'description' => 'Gala etiquette, photographer management', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'diana.al.rashid@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Diana',
            'last_name' => 'Al-Rashid',
            'age'       => 25,
            'nationality'=> 'Emirati',
            'headline'  => 'MENA Cultural Liaison & VIP Events Specialist',
            'full_bio'  => 'Raised between Dubai and London, Diana bridges Western and Middle Eastern business cultures with extraordinary ease. She is the preferred companion for clients hosting delegations from the Gulf states, managing everything from majlis protocol to halal dining coordination at Michelin-starred establishments. Available for international travel with 48h notice.',
            'hourly_rate'  => 340.00,
            'half_day_rate'=> 1100.00,
            'full_day_rate'=> 1950.00,
            'rating'    => 4.96,
            'event_types'=> ['corporate', 'diplomatic', 'luxury_travel', 'gala'],
            'languages' => [
                ['language' => 'Arabic',   'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'native'],
                ['language' => 'French',   'proficiency' => 'fluent'],
                ['language' => 'Urdu',     'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Gulf Business Protocol',     'category' => 'business', 'description' => 'Majlis etiquette, wasta dynamics, Islamic finance context', 'years_experience' => 4],
                ['skill_name' => 'Arabic-English Interpretation','category' => 'business', 'description' => 'Legal and business interpretation, MSA & Gulf dialect', 'years_experience' => 5],
                ['skill_name' => 'Luxury Real Estate Liaison', 'category' => 'business', 'description' => 'Dubai DIFC & Abu Dhabi property tour facilitation', 'years_experience' => 3],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1506863530036-1efeddceb993?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1514315384763-ba401779410f?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'valentina.greco@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Valentina',
            'last_name' => 'Greco',
            'age'       => 27,
            'nationality'=> 'Italian',
            'headline'  => 'Gastronomy Expert, Sommelier & Private Chef Liaison',
            'full_bio'  => 'Valentina trained at ALMA – La Scuola Internazionale di Cucina Italiana and holds an advanced WSET Diploma. She curates bespoke dining experiences, coordinates private chef engagements at Michelin-starred kitchens, and leads exclusive vineyard tours across Tuscany, Barolo, and Champagne region. Her palate and contacts are unrivalled.',
            'hourly_rate'  => 310.00,
            'half_day_rate'=> 1000.00,
            'full_day_rate'=> 1800.00,
            'rating'    => 4.93,
            'event_types'=> ['culinary', 'social', 'corporate', 'luxury_travel'],
            'languages' => [
                ['language' => 'Italian',  'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'Spanish',  'proficiency' => 'conversational'],
                ['language' => 'French',   'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Fine Dining & Michelin Navigation',  'category' => 'cultural', 'description' => 'Tasting menu curation and chef\'s table reservation', 'years_experience' => 6],
                ['skill_name' => 'Advanced Wine & Champagne Expertise','category' => 'cultural', 'description' => 'WSET Diploma — Barolo, Burgundy, Grower Champagne', 'years_experience' => 5],
                ['skill_name' => 'Private Chef Coordination',          'category' => 'business', 'description' => 'Liaise with 3-star chefs for private events', 'years_experience' => 3],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'zara.nkosi@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Zara',
            'last_name' => 'Nkosi',
            'age'       => 23,
            'nationality'=> 'South African',
            'headline'  => 'Wellness Curator, Mindfulness Coach & Retreat Specialist',
            'full_bio'  => 'A former competitive athlete turned certified yoga instructor and wellness consultant, Zara specialises in high-performance executive wellness. She designs personalised morning routines, accompanies clients to exclusive spas and thermal retreats, and facilitates mindfulness practices for high-pressure environments. Her energy is both calming and motivating.',
            'hourly_rate'  => 270.00,
            'half_day_rate'=> 880.00,
            'full_day_rate'=> 1600.00,
            'rating'    => 4.91,
            'event_types'=> ['wellness', 'retreat', 'social', 'luxury_travel'],
            'languages' => [
                ['language' => 'English', 'proficiency' => 'native'],
                ['language' => 'Zulu',    'proficiency' => 'native'],
                ['language' => 'French',  'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Executive Wellness Design',   'category' => 'creative', 'description' => 'Biohacking, sleep optimisation, morning protocols', 'years_experience' => 4],
                ['skill_name' => 'Yoga & Meditation Facilitation','category' => 'creative', 'description' => 'RYT-500 certified, pranayama and mindfulness', 'years_experience' => 6],
                ['skill_name' => 'Luxury Spa Curation',         'category' => 'social',   'description' => 'Access to Six Senses, Aman and ESPA properties', 'years_experience' => 3],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1526413232644-8a40f03cc03b?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'mei.lin.chen@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Mei Lin',
            'last_name' => 'Chen',
            'age'       => 29,
            'nationality'=> 'Singaporean',
            'headline'  => 'Tech & FinTech Executive Liaison — Asia Pacific',
            'full_bio'  => 'With an MBA from INSEAD and five years in venture capital in Singapore and Hong Kong, Mei Lin understands the language of tech founders and institutional investors. She is the ideal companion for investor summits, fintech conferences, and private equity networking events in Asia-Pacific. Discretion and intellectual depth are her trademarks.',
            'hourly_rate'  => 360.00,
            'half_day_rate'=> 1150.00,
            'full_day_rate'=> 2100.00,
            'rating'    => 4.98,
            'event_types'=> ['corporate', 'fintech', 'diplomatic', 'gala'],
            'languages' => [
                ['language' => 'Mandarin',  'proficiency' => 'native'],
                ['language' => 'English',   'proficiency' => 'native'],
                ['language' => 'Cantonese', 'proficiency' => 'fluent'],
                ['language' => 'Bahasa',    'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'VC & Startup Ecosystem Knowledge', 'category' => 'business', 'description' => 'SEA, Greater China, and ANZ VC landscape', 'years_experience' => 5],
                ['skill_name' => 'DeFi & Blockchain Literacy',       'category' => 'business', 'description' => 'Web3, tokenomics, institutional crypto advisory', 'years_experience' => 3],
                ['skill_name' => 'Investment Summit Facilitation',   'category' => 'business', 'description' => 'Davos, Money 20/20 Asia, SuperReturn delegate support', 'years_experience' => 4],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1496440737103-cd596325d314?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1542206395-9feb3edaa68d?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'layla.osman@velvet.demo',
            'gender'    => 'female',
            'first_name'=> 'Layla',
            'last_name' => 'Osman',
            'age'       => 22,
            'nationality'=> 'Egyptian',
            'headline'  => 'Classical Pianist & High Society Entertainment Consultant',
            'full_bio'  => 'A conservatory-trained pianist and former Miss Cairo finalist, Layla brings extraordinary poise and artistic brilliance to any event. She performs privately for distinguished guests, advises on live entertainment bookings for luxury events, and brings a rare combination of classical education and contemporary sophistication. Her presence transforms any gathering.',
            'hourly_rate'  => 300.00,
            'half_day_rate'=> 980.00,
            'full_day_rate'=> 1750.00,
            'rating'    => 4.95,
            'event_types'=> ['cultural', 'entertainment', 'gala', 'social'],
            'languages' => [
                ['language' => 'Arabic',   'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'French',   'proficiency' => 'conversational'],
                ['language' => 'Italian',  'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Classical Piano Performance',    'category' => 'creative', 'description' => 'Conservatoire de Paris graduate, Chopin & Debussy specialist', 'years_experience' => 12],
                ['skill_name' => 'Luxury Entertainment Curation', 'category' => 'social',   'description' => 'Book string quartets, jazz ensembles, opera soloists', 'years_experience' => 3],
                ['skill_name' => 'High Society Event Hosting',    'category' => 'social',   'description' => 'Toast master, MC, and salon host', 'years_experience' => 4],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=90', 'is_primary' => false],
            ],
        ],

        // ─────────── MALE COMPANIONS ───────────
        [
            'email'     => 'alexander.kingsley@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Alexander',
            'last_name' => 'Kingsley',
            'age'       => 30,
            'nationality'=> 'British',
            'headline'  => 'Former Royal Navy Officer & Elite Security Protocol Advisor',
            'full_bio'  => 'A decorated Royal Navy Commander with postgraduate studies at King\'s College London, Alexander provides an unmistakable combination of military bearing, strategic intelligence, and Savile Row elegance. He accompanies high-profile clients to political summits, private security briefings, and state dinners. Holds active DV (Developed Vetting) clearance.',
            'hourly_rate'  => 420.00,
            'half_day_rate'=> 1350.00,
            'full_day_rate'=> 2500.00,
            'rating'    => 4.98,
            'event_types'=> ['corporate', 'diplomatic', 'security', 'gala'],
            'languages' => [
                ['language' => 'English', 'proficiency' => 'native'],
                ['language' => 'Arabic',  'proficiency' => 'conversational'],
                ['language' => 'Russian', 'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'VIP Security Protocol',             'category' => 'business', 'description' => 'Risk assessment, close protection methodology', 'years_experience' => 8],
                ['skill_name' => 'Diplomatic Event Navigation',       'category' => 'business', 'description' => 'State dinner seating, embassy protocol, honors system', 'years_experience' => 6],
                ['skill_name' => 'Executive Crisis Management',       'category' => 'business', 'description' => 'Board-level scenario planning and communication', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'rafael.monteiro@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Rafael',
            'last_name' => 'Monteiro',
            'age'       => 27,
            'nationality'=> 'Brazilian',
            'headline'  => 'Luxury Yacht & Motorsport Lifestyle Consultant',
            'full_bio'  => 'Rafael grew up between São Paulo\'s elite polo circuit and Monaco\'s Formula 1 paddock. He is the ultimate companion for clients navigating the motorsport hospitality world, luxury yacht charters, and adrenaline-infused VIP experiences. A licensed skipper with 15,000 ocean miles, he also holds racing licenses in GT3 and kart categories.',
            'hourly_rate'  => 390.00,
            'half_day_rate'=> 1250.00,
            'full_day_rate'=> 2300.00,
            'rating'    => 4.95,
            'event_types'=> ['sports', 'motorsport', 'yacht', 'social'],
            'languages' => [
                ['language' => 'Portuguese', 'proficiency' => 'native'],
                ['language' => 'English',    'proficiency' => 'fluent'],
                ['language' => 'Spanish',    'proficiency' => 'fluent'],
                ['language' => 'French',     'proficiency' => 'conversational'],
                ['language' => 'Italian',    'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Yacht Charter & Ocean Navigation', 'category' => 'social',   'description' => 'RYA Yachtmaster Offshore, Med & Caribbean experience', 'years_experience' => 9],
                ['skill_name' => 'Motorsport Hospitality & Access',  'category' => 'social',   'description' => 'F1 paddock, Monaco GP, Le Mans VIP hospitality', 'years_experience' => 6],
                ['skill_name' => 'Polo & Equestrian Protocol',       'category' => 'social',   'description' => 'Accompanying clients to Guards Polo, Ascot, Kentucky Derby', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'nicolas.de.la.croix@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Nicolas',
            'last_name' => 'de la Croix',
            'age'       => 29,
            'nationality'=> 'French',
            'headline'  => 'Private Equity Professional & Art Investment Advisor',
            'full_bio'  => 'Nicolas spent seven years at BNP Paribas Wealth Management before pivoting to elite companion work, where he applies his financial acumen to a more personal setting. He assists clients in understanding luxury asset classes — from blue-chip art to vintage wine investments — at the world\'s premier auction houses. Harvard Business School executive programme alumnus.',
            'hourly_rate'  => 400.00,
            'half_day_rate'=> 1280.00,
            'full_day_rate'=> 2400.00,
            'rating'    => 4.97,
            'event_types'=> ['corporate', 'art', 'fintech', 'gala'],
            'languages' => [
                ['language' => 'French',    'proficiency' => 'native'],
                ['language' => 'English',   'proficiency' => 'native'],
                ['language' => 'German',    'proficiency' => 'fluent'],
                ['language' => 'Mandarin',  'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Wealth Management & Investment Advisory', 'category' => 'business', 'description' => 'Family office structuring, alternative assets', 'years_experience' => 7],
                ['skill_name' => 'Art Investment & Auction Navigation',     'category' => 'cultural', 'description' => 'Christie\'s, Sotheby\'s, Phillips expert companion', 'years_experience' => 5],
                ['skill_name' => 'Corporate Governance & Board Dynamics',   'category' => 'business', 'description' => 'AGM protocol, shareholder relations', 'years_experience' => 6],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'dmitri.volkonsky@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Dmitri',
            'last_name' => 'Volkonsky',
            'age'       => 28,
            'nationality'=> 'Russian',
            'headline'  => 'Strategic Communications & Media Relations Executive',
            'full_bio'  => 'A former senior press advisor at the Russian Ministry of Foreign Affairs and later at a Tier-1 PR firm in London, Dmitri masters the art of narrative management. He accompanies clients to press interviews, investor day presentations, and media-heavy galas. Exceptional at crisis communications, media coaching, and crafting the perfect public persona.',
            'hourly_rate'  => 370.00,
            'half_day_rate'=> 1200.00,
            'full_day_rate'=> 2150.00,
            'rating'    => 4.93,
            'event_types'=> ['corporate', 'diplomatic', 'media', 'gala'],
            'languages' => [
                ['language' => 'Russian',  'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'French',   'proficiency' => 'conversational'],
                ['language' => 'German',   'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Media Training & Public Speaking',  'category' => 'business', 'description' => 'Keynote coaching, press Q&A preparation, TV interviews', 'years_experience' => 8],
                ['skill_name' => 'Crisis Communications',             'category' => 'business', 'description' => 'Reputation management, stakeholder messaging', 'years_experience' => 6],
                ['skill_name' => 'Political Protocol & Diplomacy',    'category' => 'business', 'description' => 'UN General Assembly, G20 side events, embassy receptions', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'omar.al.farsi@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Omar',
            'last_name' => 'Al-Farsi',
            'age'       => 26,
            'nationality'=> 'Omani',
            'headline'  => 'Royal Protocol Expert & Middle East Investment Liaison',
            'full_bio'  => 'Omar comes from an Omani royal household and studied PPE at the University of Oxford. He facilitates introductions at the highest levels of the GCC, managing royal protocol, prayer schedule coordination, halal hospitality logistics, and investment forum access across Riyadh, Dubai, and Abu Dhabi. An indispensable bridge for Western clients entering Gulf markets.',
            'hourly_rate'  => 450.00,
            'half_day_rate'=> 1450.00,
            'full_day_rate'=> 2700.00,
            'rating'    => 5.00,
            'event_types'=> ['diplomatic', 'corporate', 'investment', 'gala'],
            'languages' => [
                ['language' => 'Arabic',   'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'native'],
                ['language' => 'French',   'proficiency' => 'fluent'],
                ['language' => 'Farsi',    'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Royal Protocol & Majlis Etiquette', 'category' => 'business', 'description' => 'Royal court access, traditional hospitality customs', 'years_experience' => 6],
                ['skill_name' => 'GCC Investment & Sovereign Wealth', 'category' => 'business', 'description' => 'Mubadala, ADIA, PIF — fund navigation and introductions', 'years_experience' => 4],
                ['skill_name' => 'Arabic-English Legal Interpretation','category' => 'business', 'description' => 'Contract negotiation interpretation, Sharia compliance context', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1556474835-b0f3ac40d4d1?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1542178243-bc20204b769f?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'gabriel.santos@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Gabriel',
            'last_name' => 'Santos',
            'age'       => 24,
            'nationality'=> 'Mexican',
            'headline'  => 'Luxury Real Estate Developer & Architecture Aesthete',
            'full_bio'  => 'Gabriel studied architecture at ITAM and subsequently joined his family\'s ultra-luxury real estate development firm across Mexico City and Miami Beach. He accompanies HNWI clients on private tours of trophy properties, art-forward residences, and developer showrooms. His refined aesthetic sensibility and Latin charm make him an extraordinary social companion.',
            'hourly_rate'  => 330.00,
            'half_day_rate'=> 1080.00,
            'full_day_rate'=> 1950.00,
            'rating'    => 4.90,
            'event_types'=> ['real_estate', 'social', 'cultural', 'corporate'],
            'languages' => [
                ['language' => 'Spanish',    'proficiency' => 'native'],
                ['language' => 'English',    'proficiency' => 'fluent'],
                ['language' => 'Portuguese', 'proficiency' => 'conversational'],
                ['language' => 'French',     'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Luxury Real Estate Advisory',      'category' => 'business', 'description' => 'UHNWI property acquisition, trophy asset evaluation', 'years_experience' => 4],
                ['skill_name' => 'Contemporary Architecture & Design','category' => 'cultural', 'description' => 'Private tours of notable buildings and design houses', 'years_experience' => 5],
                ['skill_name' => 'Latin Social Protocol',             'category' => 'social',   'description' => 'LATAM high society events, polo club access', 'years_experience' => 3],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1504257432389-52343af06ae3?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'james.whitmore@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'James',
            'last_name' => 'Whitmore',
            'age'       => 31,
            'nationality'=> 'American',
            'headline'  => 'Silicon Valley Venture Capitalist & Tech Conference Navigator',
            'full_bio'  => 'After exits at two San Francisco startups and a GP role at a seed fund, James moved to the companion sector to bring Silicon Valley\'s energy to elite events globally. His network spans Y Combinator partners to Andreessen Horowitz GPs. Perfect for clients attending CES, Web Summit, TechCrunch Disrupt, or private founder dinners.',
            'hourly_rate'  => 410.00,
            'half_day_rate'=> 1300.00,
            'full_day_rate'=> 2400.00,
            'rating'    => 4.96,
            'event_types'=> ['corporate', 'fintech', 'tech', 'investment'],
            'languages' => [
                ['language' => 'English',   'proficiency' => 'native'],
                ['language' => 'Mandarin',  'proficiency' => 'conversational'],
                ['language' => 'Spanish',   'proficiency' => 'basic'],
            ],
            'skills' => [
                ['skill_name' => 'Startup Ecosystem & VC Networking', 'category' => 'business', 'description' => 'YC, a16z, Sequoia — warm introductions', 'years_experience' => 8],
                ['skill_name' => 'Tech Conference Navigation',        'category' => 'business', 'description' => 'Davos, CES, Web Summit, Milken VIP access strategy', 'years_experience' => 6],
                ['skill_name' => 'M&A Deal Facilitation',             'category' => 'business', 'description' => 'Term sheet dynamics, founder/VC relationship building', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1488161628813-04466f872be2?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'hiroshi.yamamoto@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Hiroshi',
            'last_name' => 'Yamamoto',
            'age'       => 28,
            'nationality'=> 'Japanese',
            'headline'  => 'Japanese Business Protocol Master & Corporate Gift Advisor',
            'full_bio'  => 'A Keio University graduate with an MBA from Wharton, Hiroshi has guided over 200 Western executives through the intricacies of Japanese corporate culture. He manages gift-giving hierarchies, keigo (honorific language) translation, business card exchange etiquette, and nemawashi (consensus building) processes. The essential companion for Japan market entry.',
            'hourly_rate'  => 360.00,
            'half_day_rate'=> 1150.00,
            'full_day_rate'=> 2100.00,
            'rating'    => 4.99,
            'event_types'=> ['corporate', 'diplomatic', 'luxury_travel', 'cultural'],
            'languages' => [
                ['language' => 'Japanese',  'proficiency' => 'native'],
                ['language' => 'English',   'proficiency' => 'native'],
                ['language' => 'Mandarin',  'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'Japanese Corporate Protocol',      'category' => 'business', 'description' => 'Nemawashi, keigo, gift hierarchy, meishi rituals', 'years_experience' => 7],
                ['skill_name' => 'Tokyo Business Navigation',        'category' => 'business', 'description' => 'Marunouchi, Roppongi Hills, Karuizawa HNWI network', 'years_experience' => 5],
                ['skill_name' => 'Traditional Japanese Experience',  'category' => 'cultural', 'description' => 'Omakase bookings, ryokan, Noh theatre, tea master introduction', 'years_experience' => 8],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1557862921-37829c790f19?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1566492031773-4f4e44671857?w=800&q=90', 'is_primary' => false],
            ],
        ],
        [
            'email'     => 'leon.beaumont@velvet.demo',
            'gender'    => 'male',
            'first_name'=> 'Léon',
            'last_name' => 'Beaumont',
            'age'       => 25,
            'nationality'=> 'Belgian',
            'headline'  => 'EU Political Advisor & Luxury Hospitality Connoisseur',
            'full_bio'  => 'Léon worked in the European Parliament as a senior policy advisor before transitioning into the world of ultra-premium lifestyle consulting. He has intimate knowledge of Brussels political circles, EU regulatory landscapes, and the grand hotel traditions of continental Europe. An extraordinary companion for anyone navigating the EU institutional world or European high society.',
            'hourly_rate'  => 345.00,
            'half_day_rate'=> 1100.00,
            'full_day_rate'=> 2000.00,
            'rating'    => 4.92,
            'event_types'=> ['corporate', 'diplomatic', 'political', 'gala'],
            'languages' => [
                ['language' => 'French',   'proficiency' => 'native'],
                ['language' => 'Dutch',    'proficiency' => 'native'],
                ['language' => 'English',  'proficiency' => 'fluent'],
                ['language' => 'German',   'proficiency' => 'fluent'],
                ['language' => 'Italian',  'proficiency' => 'conversational'],
            ],
            'skills' => [
                ['skill_name' => 'EU Regulatory & Lobbying Navigation', 'category' => 'business', 'description' => 'Commission, Parliament, Council access and advocacy', 'years_experience' => 5],
                ['skill_name' => 'Grand Hotel Traditions & Spa Culture','category' => 'social',   'description' => 'Hotel Metropole, Amigo, Schloss Elmau concierge expertise', 'years_experience' => 4],
                ['skill_name' => 'Belgian Chocolate & Fine Dining',    'category' => 'cultural', 'description' => 'Michelin navigation across Benelux, private chef introductions', 'years_experience' => 5],
            ],
            'photos' => [
                ['url' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=800&q=90', 'is_primary' => true],
                ['url' => 'https://images.unsplash.com/photo-1508341591423-4347099e1f19?w=800&q=90', 'is_primary' => false],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->companions as $data) {
            $user = User::create([
                'email'    => $data['email'],
                'password' => Hash::make('VelvetDemo2024!'),
                'role'     => 'companion',
                'status'   => 'active',
                'email_verified' => true,
            ]);

            UserProfile::create([
                'user_id'     => $user->id,
                'first_name'  => $data['first_name'],
                'last_name'   => $data['last_name'],
                'gender'      => $data['gender'],
                'nationality' => $data['nationality'],
                'city'        => 'Tashkent',
                'country'     => 'Uzbekistan',
            ]);

            $companion = Companion::create([
                'user_id'         => $user->id,
                'age'             => $data['age'],
                'is_verified'     => true,
                'is_featured'     => $data['rating'] >= 4.95,
                'photos_blurred'  => true,
                'hourly_rate'     => $data['hourly_rate'],
                'half_day_rate'   => $data['half_day_rate'],
                'full_day_rate'   => $data['full_day_rate'],
                'availability_status' => 'available',
                'rating'          => $data['rating'],
                'total_reviews'   => rand(18, 65),
                'total_bookings'  => rand(30, 120),
                'headline'        => $data['headline'],
                'full_bio'        => $data['full_bio'],
                'event_types'     => $data['event_types'],
                'verified_at'     => now()->subMonths(rand(3, 18)),
            ]);

            foreach ($data['languages'] as $lang) {
                CompanionLanguage::create([
                    'companion_id' => $companion->id,
                    'language'     => $lang['language'],
                    'proficiency'  => $lang['proficiency'],
                ]);
            }

            foreach ($data['skills'] as $skill) {
                CompanionSkill::create([
                    'companion_id'     => $companion->id,
                    'skill_name'       => $skill['skill_name'],
                    'category'         => $skill['category'],
                    'description'      => $skill['description'],
                    'years_experience' => $skill['years_experience'],
                ]);
            }

            foreach ($data['photos'] as $index => $photo) {
                CompanionPhoto::create([
                    'companion_id' => $companion->id,
                    'original_url' => $photo['url'],
                    'blurred_url'  => $photo['url'] . '&blur=20', // Cloudinary/Imgix blur param
                    'thumbnail_url'=> $photo['url'] . '&w=200',
                    'is_primary'   => $photo['is_primary'],
                    'is_verified'  => true,
                    'sort_order'   => $index,
                ]);
            }
        }

        $this->command->info('✓ Seeded 18 elite companion profiles (9F + 9M)');
    }
}
