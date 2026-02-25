<?php

namespace Database\Seeders;

use App\Models\FrontendPage;
use App\Models\FrontendSection;
use Illuminate\Database\Seeder;

/**
 * Seeds initial multilingual frontend CMS content.
 *
 * @category Database
 * @package  Database\Seeders
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class FrontendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $pages = [
            'home' => [
                [
                    'section_key' => 'hero_primary',
                    'title_en' => 'Learn with Experts',
                    'title_bn' => 'বিশেষজ্ঞদের সাথে শিখুন',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
                [
                    'section_key' => 'hero_emphasis',
                    'title_en' => 'Build Real Projects',
                    'title_bn' => 'বাস্তব প্রজেক্ট তৈরি করুন',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
                [
                    'section_key' => 'hero_paragraph',
                    'content_en' => implode(
                        ' ',
                        [
                            'Career-focused training with mentor guidance,',
                            'weekly reviews, and portfolio-ready projects.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'ক্যারিয়ার-ফোকাসড ট্রেনিং, মেন্টর গাইডেন্স,',
                            'সাপ্তাহিক রিভিউ এবং পোর্টফোলিও-রেডি প্রজেক্ট।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
                [
                    'section_key' => 'hero_cta_primary',
                    'button_text_en' => 'Explore Courses',
                    'button_text_bn' => 'কোর্স দেখুন',
                    'button_link' => '/courses',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'about' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'About Us',
                    'title_bn' => 'আমাদের সম্পর্কে',
                    'content_en' => implode(
                        ' ',
                        [
                            'We help learners build real-world skills',
                            'with mentor-led learning, structured modules,',
                            'and project-based outcomes.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'আমরা মেন্টর-লেড লার্নিং, স্ট্রাকচার্ড মডিউল এবং',
                            'প্রজেক্ট-বেইজড আউটকামের মাধ্যমে বাস্তব স্কিল গড়ে',
                            'তুলতে সাহায্য করি।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'courses' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Courses',
                    'title_bn' => 'কোর্সসমূহ',
                    'content_en' => implode(
                        ' ',
                        [
                            'Choose a path and start building your portfolio',
                            'with guided practice and real projects.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'একটি পথ বেছে নিন এবং গাইডেড প্র্যাকটিস ও',
                            'বাস্তব প্রজেক্টের মাধ্যমে আপনার পোর্টফোলিও',
                            'তৈরি শুরু করুন।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'contact' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Contact',
                    'title_bn' => 'যোগাযোগ',
                    'content_en' => implode(
                        ' ',
                        [
                            'Have questions? Reach out and we will get back to you',
                            'as soon as possible.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'কোনো প্রশ্ন আছে? যোগাযোগ করুন, আমরা দ্রুত',
                            'উত্তর দেওয়ার চেষ্টা করব।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
                [
                    'section_key' => 'contact_email',
                    'title_en' => 'Email',
                    'title_bn' => 'ইমেইল',
                    'content_en' => 'info@example.com',
                    'content_bn' => 'info@example.com',
                    'button_link' => 'mailto:info@example.com',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
                [
                    'section_key' => 'contact_phone',
                    'title_en' => 'Phone',
                    'title_bn' => 'ফোন',
                    'content_en' => '+880 10 0000 0000',
                    'content_bn' => '+880 10 0000 0000',
                    'button_link' => 'tel:+8801000000000',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'mentors' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Mentors',
                    'title_bn' => 'মেন্টরস',
                    'content_en' => implode(
                        ' ',
                        [
                            'Meet mentors from different topics',
                            'and learn with weekly guidance.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'বিভিন্ন টপিকের মেন্টরদের সাথে পরিচিত হন এবং',
                            'সাপ্তাহিক গাইডেন্সের মাধ্যমে শিখুন।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'news' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'News',
                    'title_bn' => 'নিউজ',
                    'content_en' => 'Latest updates, workshops, and announcements.',
                    'content_bn' => 'সর্বশেষ আপডেট, ওয়ার্কশপ এবং ঘোষণা।',
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'reviews' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Reviews',
                    'title_bn' => 'রিভিউ',
                    'content_en' => implode(
                        ' ',
                        [
                            'What learners say about our mentoring and courses.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'আমাদের মেন্টরিং এবং কোর্স সম্পর্কে',
                            'শিক্ষার্থীদের মতামত।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'privacy' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Privacy Policy',
                    'title_bn' => 'প্রাইভেসি পলিসি',
                    'content_en' => implode(
                        ' ',
                        [
                            'Replace this placeholder text',
                            'with your real privacy policy.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'এই প্লেসহোল্ডার টেক্সটটি আপনার',
                            'আসল প্রাইভেসি পলিসি দিয়ে বদলে দিন।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
            'terms' => [
                [
                    'section_key' => 'hero',
                    'title_en' => 'Terms & Conditions',
                    'title_bn' => 'শর্তাবলী',
                    'content_en' => implode(
                        ' ',
                        [
                            'Replace this placeholder text',
                            'with your real terms and conditions.',
                        ]
                    ),
                    'content_bn' => implode(
                        ' ',
                        [
                            'এই প্লেসহোল্ডার টেক্সটটি আপনার',
                            'আসল শর্তাবলী দিয়ে বদলে দিন।',
                        ]
                    ),
                    'status' => FrontendSection::STATUS_ACTIVE,
                ],
            ],
        ];

        foreach ($pages as $slug => $sections) {
            $page = FrontendPage::query()->firstOrCreate(['slug' => $slug]);

            foreach ($sections as $section) {
                FrontendSection::query()->updateOrCreate(
                    [
                        'frontend_page_id' => $page->id,
                        'section_key' => $section['section_key'],
                    ],
                    array_merge($section, ['frontend_page_id' => $page->id])
                );
            }
        }
    }
}
