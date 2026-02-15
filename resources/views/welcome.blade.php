@extends('layouts.site')

@section('title', config('app.name', 'iTechBD Ltd'))

@section('content')

    <main id="top">
        <!-- Hero -->
        <section class="relative">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
                <div class="lg:col-span-7">
                    <div class="reveal inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs text-slate-200 ring-1 ring-white/10">
                        <span class="itech-pulse-dot inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                        Job-ready training with real projects
                        <span class="hidden text-slate-300 sm:inline">•</span>
                        <span class="hidden text-slate-300 sm:inline">Mentor support • Career guidance</span>
                    </div>

                    <h1 class="reveal mt-6 text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Learn from the most experienced mentors in Bangladesh —
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-sky-300 to-emerald-300 animate-gradient">become career-ready</span>
                    </h1>

                    <p class="reveal mt-5 max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg">
                        Build a strong portfolio with industry-standard skills. Our trainers and mentors are top-positioned professionals,
                        and we focus on practical learning, interview preparation, and real-world problem solving.
                        Many of our students become active freelancers and professionals working with leading IT companies in Bangladesh.
                    </p>

                    <div class="reveal mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('courses') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                            Explore Courses
                        </a>
                        <a href="#outcomes"
                           class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/15">
                            See Student Outcomes
                        </a>
                    </div>

                    <div class="reveal mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-xs text-slate-300">Live Classes</div>
                            <div class="mt-1 font-semibold text-white">Mentor-led</div>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-xs text-slate-300">Projects</div>
                            <div class="mt-1 font-semibold text-white">Portfolio-ready</div>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-xs text-slate-300">Support</div>
                            <div class="mt-1 font-semibold text-white">Career guidance</div>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-xs text-slate-300">Community</div>
                            <div class="mt-1 font-semibold text-white">Active learners</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="reveal relative overflow-hidden rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="absolute inset-0 opacity-30"
                             style="background: radial-gradient(circle at 20% 10%, rgba(99,102,241,.35), transparent 55%), radial-gradient(circle at 80% 30%, rgba(14,165,233,.30), transparent 50%), radial-gradient(circle at 40% 90%, rgba(16,185,129,.25), transparent 55%);"></div>

                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs text-slate-300">Why choose us</div>
                                    <div class="mt-1 text-lg font-semibold text-white">What makes us different</div>
                                </div>
                                <div class="rounded-2xl bg-white/10 px-3 py-2 text-xs text-slate-200 ring-1 ring-white/10">
                                    Mentor-led, career-focused
                                </div>
                            </div>

                            <div class="mt-6">
                                <div id="differentReasonsViewport" class="overflow-hidden" data-force-motion="1">
                                    <div id="differentReasonsTrack" class="flex flex-col gap-4 will-change-transform">
                                        <div class="different-reason rounded-2xl bg-slate-950/40 p-4 ring-1 ring-white/10">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 rounded-xl bg-indigo-500/20 p-2 ring-1 ring-indigo-400/20">
                                            <div class="text-xs font-semibold text-indigo-100">Career Track</div>
                                            <div class="mt-1 text-sm text-slate-200">CV + interview prep + real projects</div>
                                        </div>
                                        <div class="text-sm text-slate-200">Structured growth path from basics to advanced.</div>
                                    </div>
                                        </div>

                                        <div class="different-reason rounded-2xl bg-slate-950/40 p-4 ring-1 ring-white/10">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 rounded-xl bg-sky-500/20 p-2 ring-1 ring-sky-400/20">
                                            <div class="text-xs font-semibold text-sky-100">Freelancing Support</div>
                                            <div class="mt-1 text-sm text-slate-200">Profile + proposal + client communication</div>
                                        </div>
                                        <div class="text-sm text-slate-200">Learn how to work with real clients professionally.</div>
                                    </div>
                                        </div>

                                        <div class="different-reason rounded-2xl bg-slate-950/40 p-4 ring-1 ring-white/10">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 rounded-xl bg-emerald-500/20 p-2 ring-1 ring-emerald-400/20">
                                            <div class="text-xs font-semibold text-emerald-100">Progress Tracking</div>
                                            <div class="mt-1 text-sm text-slate-200">Weekly tasks + reviews</div>
                                        </div>
                                        <div class="text-sm text-slate-200">Stay consistent with milestones and feedback.</div>
                                    </div>
                                        </div>

                                        <div class="different-reason rounded-2xl bg-slate-950/40 p-4 ring-1 ring-white/10">
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 rounded-xl bg-violet-500/20 p-2 ring-1 ring-violet-400/20">
                                                    <div class="text-xs font-semibold text-violet-100">Community & Networking</div>
                                                    <div class="mt-1 text-sm text-slate-200">Peer support + job updates</div>
                                                </div>
                                                <div class="text-sm text-slate-200">Connect with learners and mentors beyond the classroom.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="contact" class="mt-6 rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                                <div class="text-sm font-semibold text-white">Need details?</div>
                                <div class="mt-1 text-sm text-slate-200">Get course outline, schedule and fees.</div>
                                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                    <a href="mailto:info@example.com"
                                       class="inline-flex flex-1 items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                                        Email Us
                                    </a>
                                    <a href="#faq"
                                       class="inline-flex flex-1 items-center justify-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/15">
                                        Read FAQ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About -->
        <section id="about" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal">
                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">Why Choose iTechBD</h2>
                    <p class="mt-2 max-w-3xl text-slate-200">We focus on job-ready skills, mentorship, and real projects. Learn with top-positioned trainers and mentors, get regular reviews, and build a portfolio that helps you in jobs and freelancing.</p>
                </div>

                <div class="reveal mt-10 grid gap-6 md:grid-cols-3">
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm font-semibold text-white">Mentor-led learning</div>
                        <p class="mt-2 text-sm text-slate-200">Weekly guidance, code/design reviews, and a clear learning path.</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm font-semibold text-white">Portfolio first</div>
                        <p class="mt-2 text-sm text-slate-200">Projects that showcase your skills and help you stand out.</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm font-semibold text-white">Career + freelancing support</div>
                        <p class="mt-2 text-sm text-slate-200">Interview practice, client communication, and practical guidance.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Courses -->
        <section id="courses" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-white sm:text-3xl">Our Skill Tracks</h2>
                        <p class="mt-2 max-w-2xl text-slate-200">Choose a course, learn by doing, and build a strong portfolio.</p>
                    </div>
                    <a href="#outcomes" class="text-sm font-medium text-sky-200 hover:text-sky-100">How we help you get hired →</a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                        <h3 class="text-lg font-semibold text-white">Web Development</h3>
                        <p class="mt-1 text-sm text-slate-200">Front-end + back-end fundamentals with real projects.</p>
                        <ul class="mt-5 space-y-2 text-sm text-slate-200">
                            <li>• HTML, CSS, TailwindCSS, JavaScript</li>
                            <li>• Responsive UI + animations + components</li>
                            <li>• APIs, database basics, deployment basics</li>
                        </ul>
                    </article>

                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                        <h3 class="text-lg font-semibold text-white">SEO (Search Engine Optimization)</h3>
                        <p class="mt-1 text-sm text-slate-200">Technical SEO + content + analytics.</p>
                        <ul class="mt-5 space-y-2 text-sm text-slate-200">
                            <li>• On-page, off-page, technical SEO</li>
                            <li>• Keyword research + content planning</li>
                            <li>• Analytics basics + reporting</li>
                        </ul>
                    </article>

                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                        <h3 class="text-lg font-semibold text-white">.NET Development</h3>
                        <p class="mt-1 text-sm text-slate-200">C# + ASP.NET Core for modern applications.</p>
                        <ul class="mt-5 space-y-2 text-sm text-slate-200">
                            <li>• C# fundamentals + OOP</li>
                            <li>• ASP.NET Core APIs + auth basics</li>
                            <li>• Database + EF Core basics</li>
                        </ul>
                    </article>

                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                        <h3 class="text-lg font-semibold text-white">Graphics Design</h3>
                        <p class="mt-1 text-sm text-slate-200">Branding + marketing visuals + portfolio.</p>
                        <ul class="mt-5 space-y-2 text-sm text-slate-200">
                            <li>• Photoshop / Illustrator fundamentals</li>
                            <li>• Branding, typography, layouts</li>
                            <li>• Portfolio + client workflow</li>
                        </ul>
                    </article>

                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                        <h3 class="text-lg font-semibold text-white">Extra Topics (Optional)</h3>
                        <p class="mt-1 text-sm text-slate-200">UI/UX, Git, communication and teamwork.</p>
                        <ul class="mt-5 space-y-2 text-sm text-slate-200">
                            <li>• UI/UX basics (Figma)</li>
                            <li>• Git basics + teamwork</li>
                            <li>• Client communication</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- Mentors -->
        <section id="mentors" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal">
                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">Mentors</h2>
                    <p class="mt-2 max-w-2xl text-slate-200">Top-positioned mentors guide you with reviews, projects, and career support.</p>
                </div>

                <div class="reveal mt-10">
                    <div class="relative">
                        <div class="mb-3 flex items-center justify-end gap-2">
                            <button id="mentorPrev" type="button" aria-label="Previous mentors" class="inline-flex items-center justify-center rounded-xl bg-slate-950/70 px-3 py-2 text-white ring-1 ring-white/10 backdrop-blur transition hover:bg-slate-950/90">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                    <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button id="mentorNext" type="button" aria-label="Next mentors" class="inline-flex items-center justify-center rounded-xl bg-slate-950/70 px-3 py-2 text-white ring-1 ring-white/10 backdrop-blur transition hover:bg-slate-950/90">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <div id="mentorCarousel" class="mentor-carousel flex gap-6 overflow-x-auto scroll-smooth pb-2">
                            @forelse ($mentors ?? [] as $mentor)
                                <div class="mentor-card shrink-0 basis-full overflow-hidden rounded-3xl bg-white/5 ring-1 ring-white/10 sm:basis-[calc(50%-0.75rem)] lg:basis-[calc(25%-1.125rem)]">
                                    <div class="aspect-square w-full bg-slate-950/30 grid place-items-center">
                                        <svg viewBox="0 0 24 24" fill="none" class="h-24 w-24 text-slate-200/70 sm:h-28 sm:w-28" aria-hidden="true">
                                            <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" fill="currentColor" opacity="0.85" />
                                            <path d="M3.2 21c2.3-4.3 6.2-6.7 8.8-6.7S18.5 16.7 20.8 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" opacity="0.85" />
                                        </svg>
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm font-semibold text-white">{{ $mentor->name }}</div>
                                        <div class="mt-1 text-xs text-slate-300">{{ $mentor->topic ?? 'Mentor' }} • Weekly support</div>
                                        <p class="mt-3 text-sm text-slate-200">{{ $mentor->bio ?: 'Project review, guidance, and best practices to level up fast.' }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 text-slate-200">No mentors available yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reviews -->
        <section id="reviews" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal">
                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">Student Reviews</h2>
                    <p class="mt-2 max-w-2xl text-slate-200">Real feedback from learners who improved their skills, careers, and freelancing journey.</p>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @php
                        $reviews = [
                            ['name' => 'Student', 'quote' => 'Mentors were very supportive. The project reviews helped me build a strong portfolio.'],
                            ['name' => 'Freelancer', 'quote' => 'I learned how to communicate with clients and improved my proposals. Great guidance for freelancing.'],
                            ['name' => 'Job Seeker', 'quote' => 'The CV + interview practice sessions were super helpful. I felt confident applying for roles.'],
                        ];
                    @endphp

                    @foreach ($reviews as $r)
                        <div class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                            <div class="flex items-center gap-1 text-amber-300" aria-label="5 star rating">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.71c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .951-.69l1.07-3.292Z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-4 text-sm text-slate-200">“{{ $r['quote'] }}”</p>
                            <div class="mt-4 text-xs font-semibold text-white">— {{ $r['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Outcomes -->
        <section id="outcomes" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal">
                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">Student Outcomes</h2>
                    <p class="mt-2 max-w-2xl text-slate-200">Students get good jobs and become top-rated freelancers by building real skills and strong portfolios.</p>
                </div>

                <div class="reveal mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm text-slate-300">Projects</div>
                        <div class="mt-2 text-3xl font-semibold text-white" data-counter="6">0</div>
                        <div class="mt-2 text-sm text-slate-200">Portfolio-ready work</div>
                    </div>
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm text-slate-300">Career sessions</div>
                        <div class="mt-2 text-3xl font-semibold text-white" data-counter="12">0</div>
                        <div class="mt-2 text-sm text-slate-200">CV + interview practice</div>
                    </div>
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm text-slate-300">Freelancing track</div>
                        <div class="mt-2 text-3xl font-semibold text-white" data-counter="1">0</div>
                        <div class="mt-2 text-sm text-slate-200">Client-ready guidance</div>
                    </div>
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-sm text-slate-300">Support</div>
                        <div class="mt-2 text-3xl font-semibold text-white" data-counter="24">0</div>
                        <div class="mt-2 text-sm text-slate-200">Community + mentor help</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News -->
        <section id="news" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-white sm:text-3xl">News & Updates</h2>
                        <p class="mt-2 max-w-2xl text-slate-200">Announcements, workshops, and upcoming batches.</p>
                    </div>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-sky-200 hover:text-sky-100">Get schedule & fees →</a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-xs text-slate-300">Batch Update</div>
                        <h3 class="mt-2 text-base font-semibold text-white">New batch enrollment open</h3>
                        <p class="mt-2 text-sm text-slate-200">Limited seats with mentor-led support and weekly reviews.</p>
                    </article>
                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-xs text-slate-300">Workshop</div>
                        <h3 class="mt-2 text-base font-semibold text-white">Portfolio & LinkedIn session</h3>
                        <p class="mt-2 text-sm text-slate-200">Improve your profile and showcase projects professionally.</p>
                    </article>
                    <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-xs text-slate-300">Freelancing</div>
                        <h3 class="mt-2 text-base font-semibold text-white">Client communication Q&A</h3>
                        <p class="mt-2 text-sm text-slate-200">Learn proposals, scope, and how to handle real clients.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- FAQ / CTA -->
        <section id="faq" class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="reveal">
                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">FAQ</h2>
                    <p class="mt-2 max-w-2xl text-slate-200">Common questions about batches, mentoring, and support.</p>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    <div class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <h3 class="text-base font-semibold text-white">Do I need prior experience?</h3>
                        <p class="mt-2 text-sm text-slate-200">No. We start from fundamentals and gradually move to projects.</p>
                    </div>
                    <div class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <h3 class="text-base font-semibold text-white">Will you help with jobs and freelancing?</h3>
                        <p class="mt-2 text-sm text-slate-200">Yes. We support CV, interview practice, and freelancing guidance.</p>
                    </div>
                </div>

                <div class="reveal mt-10 rounded-3xl bg-gradient-to-r from-indigo-500/20 via-sky-500/15 to-emerald-500/20 p-8 ring-1 ring-white/10">
                    <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Ready to start?</h3>
                            <p class="mt-1 text-sm text-slate-200">Join a batch and build your future.</p>
                        </div>
                        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                            <a href="{{ route('courses') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">View Courses</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/15">Enroll Now</a>
                            @else
                                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/15">Contact</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        (function () {
            var revealEls = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
            var counterEls = Array.prototype.slice.call(document.querySelectorAll('[data-counter]'));

            function animateCount(el) {
                var target = parseInt(el.getAttribute('data-counter'), 10);
                if (!Number.isFinite(target) || el.__counted) return;
                el.__counted = true;

                var duration = 900;
                var start = 0;
                var startTime = null;

                function step(ts) {
                    if (!startTime) startTime = ts;
                    var p = Math.min(1, (ts - startTime) / duration);
                    var eased = 1 - Math.pow(1 - p, 3);
                    var value = Math.round(start + (target - start) * eased);
                    el.textContent = value;
                    if (p < 1) requestAnimationFrame(step);
                }

                requestAnimationFrame(step);
            }

            if (!('IntersectionObserver' in window)) {
                revealEls.forEach(function (el) { el.classList.add('is-visible'); });
                counterEls.forEach(animateCount);
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        if (entry.target.hasAttribute('data-counter')) animateCount(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -10% 0px' });

            revealEls.forEach(function (el) { observer.observe(el); });
            counterEls.forEach(function (el) { observer.observe(el); });

            // Mentors carousel
            var carousel = document.getElementById('mentorCarousel');
            if (carousel) {
                var prevBtn = document.getElementById('mentorPrev');
                var nextBtn = document.getElementById('mentorNext');
                var reduceMotion = false;

                try {
                    reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                } catch (e) {
                    reduceMotion = false;
                }

                function behavior() {
                    return reduceMotion ? 'auto' : 'smooth';
                }

                function maxScrollLeft() {
                    return Math.max(0, carousel.scrollWidth - carousel.clientWidth);
                }

                function step() {
                    return Math.max(240, carousel.clientWidth);
                }

                function goNext() {
                    var maxLeft = maxScrollLeft();
                    if (carousel.scrollLeft >= maxLeft - 2) {
                        carousel.scrollTo({ left: 0, behavior: behavior() });
                        return;
                    }
                    carousel.scrollBy({ left: step(), behavior: behavior() });
                }

                function goPrev() {
                    var maxLeft = maxScrollLeft();
                    if (carousel.scrollLeft <= 2) {
                        carousel.scrollTo({ left: maxLeft, behavior: behavior() });
                        return;
                    }
                    carousel.scrollBy({ left: -step(), behavior: behavior() });
                }

                if (prevBtn) prevBtn.addEventListener('click', goPrev);
                if (nextBtn) nextBtn.addEventListener('click', goNext);

                var timer = null;
                function stop() {
                    if (timer) window.clearInterval(timer);
                    timer = null;
                }

                function start() {
                    stop();
                    if (reduceMotion) return;
                    timer = window.setInterval(goNext, 3200);
                }

                carousel.addEventListener('mouseenter', stop);
                carousel.addEventListener('mouseleave', start);
                carousel.addEventListener('focusin', stop);
                carousel.addEventListener('focusout', start);
                carousel.addEventListener('touchstart', stop, { passive: true });
                carousel.addEventListener('touchend', start, { passive: true });

                start();
            }

            // What makes us different (vertical ticker)
            var reasonsViewport = document.getElementById('differentReasonsViewport');
            var reasonsTrack = document.getElementById('differentReasonsTrack');
            if (reasonsViewport && reasonsTrack) {
                var reduceReasonsMotion = false;

                try {
                    reduceReasonsMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                } catch (e) {
                    reduceReasonsMotion = false;
                }

                var forceReasonsMotion = reasonsViewport.getAttribute('data-force-motion') === '1';
                if (forceReasonsMotion) reduceReasonsMotion = false;

                var visibleCount = 3;
                var durationMs = 650;
                var intervalMs = 2600;

                var originalItems = Array.prototype.slice.call(reasonsTrack.querySelectorAll('.different-reason'));
                var originalCount = originalItems.length;

                function setStaticViewportHeight() {
                    var itemsNow = reasonsTrack.querySelectorAll('.different-reason');
                    if (!itemsNow || itemsNow.length < 2) return;

                    var r1 = itemsNow[0].getBoundingClientRect();
                    var r2 = itemsNow[1].getBoundingClientRect();
                    var step = Math.round(r2.top - r1.top);
                    if (!step || step <= 0) step = Math.round(r1.height + 16);

                    var viewportHeight = Math.round(r1.height + step * (visibleCount - 1));
                    reasonsViewport.style.height = viewportHeight + 'px';
                }

                if (originalCount > visibleCount) {
                    setStaticViewportHeight();

                    if (reduceReasonsMotion) {
                        var staticResizeTimer = null;
                        window.addEventListener('resize', function () {
                            if (staticResizeTimer) window.clearTimeout(staticResizeTimer);
                            staticResizeTimer = window.setTimeout(setStaticViewportHeight, 120);
                        });
                    }
                }

                if (!reduceReasonsMotion && originalCount > visibleCount) {
                    // Clone first N items for a seamless loop.
                    var cloneCount = Math.min(visibleCount, originalCount);
                    for (var i = 0; i < cloneCount; i++) {
                        var clone = originalItems[i].cloneNode(true);
                        clone.setAttribute('data-clone', '1');
                        reasonsTrack.appendChild(clone);
                    }

                    reasonsTrack.style.transitionProperty = 'transform';
                    reasonsTrack.style.transitionTimingFunction = 'cubic-bezier(0.4, 0, 0.2, 1)';
                    reasonsTrack.style.transitionDuration = durationMs + 'ms';

                    var stepPx = 0;
                    var firstHeight = 0;
                    var index = 0;
                    var timer2 = null;
                    var resetting = false;

                    function measure() {
                        var itemsNow = reasonsTrack.querySelectorAll('.different-reason');
                        if (!itemsNow || itemsNow.length < 2) return;

                        var r1 = itemsNow[0].getBoundingClientRect();
                        var r2 = itemsNow[1].getBoundingClientRect();

                        firstHeight = r1.height;
                        stepPx = Math.round(r2.top - r1.top);

                        if (!stepPx || stepPx <= 0) {
                            // Fallback: item height + 16px (gap-4)
                            stepPx = Math.round(r1.height + 16);
                        }

                        // Show exactly 3 items; the 4th stays hidden until scroll.
                        var viewportHeight = Math.round(firstHeight + stepPx * (visibleCount - 1));
                        reasonsViewport.style.height = viewportHeight + 'px';

                        // Keep current position after resize.
                        reasonsTrack.style.transform = 'translateY(' + (-index * stepPx) + 'px)';
                    }

                    function stopReasons() {
                        if (timer2) window.clearInterval(timer2);
                        timer2 = null;
                    }

                    function resetIfNeeded() {
                        if (index !== originalCount) return;
                        resetting = true;
                        // Jump back to the start after reaching the clones.
                        reasonsTrack.style.transitionProperty = 'none';
                        reasonsTrack.style.transform = 'translateY(0px)';
                        // Force reflow so the browser applies the transform before re-enabling transition.
                        void reasonsTrack.offsetHeight;
                        reasonsTrack.style.transitionProperty = 'transform';
                        index = 0;
                        resetting = false;
                    }

                    function tick() {
                        if (!stepPx || resetting) return;
                        index += 1;
                        reasonsTrack.style.transform = 'translateY(' + (-index * stepPx) + 'px)';

                        if (index === originalCount) {
                            window.setTimeout(resetIfNeeded, durationMs + 60);
                        }
                    }

                    function startReasons() {
                        stopReasons();
                        timer2 = window.setInterval(tick, intervalMs);
                    }

                    reasonsViewport.addEventListener('mouseenter', stopReasons);
                    reasonsViewport.addEventListener('mouseleave', startReasons);
                    reasonsViewport.addEventListener('focusin', stopReasons);
                    reasonsViewport.addEventListener('focusout', startReasons);

                    measure();

                    var resizeTimer = null;
                    window.addEventListener('resize', function () {
                        if (resizeTimer) window.clearTimeout(resizeTimer);
                        resizeTimer = window.setTimeout(measure, 120);
                    });

                    startReasons();
                }
            }
        })();
    </script>
@endpush
