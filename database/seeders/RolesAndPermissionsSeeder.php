<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $mentorPermissions = [
            'addMentor',
            'readMentor',
            'editMentor',
            'deleteMentor',
        ];

        foreach ($mentorPermissions as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        /** @var Role $adminRole */
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        /** @var Role $studentRole */
        $studentRole = Role::query()->firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        // teacher -> mentor (rename/merge)
        /** @var Role|null $mentorRole */
        $mentorRole = Role::query()->where('name', 'mentor')->where('guard_name', 'web')->first();
        /** @var Role|null $teacherRole */
        $teacherRole = Role::query()->where('name', 'teacher')->where('guard_name', 'web')->first();

        if (! $mentorRole && $teacherRole) {
            $teacherRole->name = 'mentor';
            $teacherRole->save();
            $mentorRole = $teacherRole;
        }

        if (! $mentorRole) {
            $mentorRole = Role::query()->firstOrCreate(['name' => 'mentor', 'guard_name' => 'web']);
        }

        if ($teacherRole && $mentorRole && $teacherRole->id !== $mentorRole->id) {
            // Merge: move permissions + users from teacher to mentor then delete teacher role
            $mentorRole->givePermissionTo($teacherRole->permissions);

            foreach ($teacherRole->users as $user) {
                $user->assignRole($mentorRole);
                $user->removeRole($teacherRole);
            }

            $teacherRole->delete();
        }

        // Admin has all permissions
        $adminRole->syncPermissions(Permission::all());

        // Student can only read mentors
        $studentRole->syncPermissions([
            'readMentor',
        ]);

        // Mentor can read mentors + edit their personal mentor profile (policy restricts to own)
        $mentorRole->syncPermissions([
            'readMentor',
            'editMentor',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
