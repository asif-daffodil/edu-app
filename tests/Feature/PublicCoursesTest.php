<?php

use App\Models\User;
use Modules\Course\Models\Course;

test('public course details page can be viewed for active course', function () {
    $user = User::factory()->create();

    $course = Course::query()->create([
        'title' => 'Test Course',
        'description' => 'Test description',
        'thumbnail' => null,
        'status' => 'active',
        'created_by' => $user->id,
    ]);

    $this
        ->get(route('courses.show', $course))
        ->assertOk()
        ->assertSee('Test Course');
});

test('public course details page returns 404 for inactive course', function () {
    $user = User::factory()->create();

    $course = Course::query()->create([
        'title' => 'Inactive Course',
        'description' => 'Hidden',
        'thumbnail' => null,
        'status' => 'inactive',
        'created_by' => $user->id,
    ]);

    $this->get(route('courses.show', $course))->assertNotFound();
});
