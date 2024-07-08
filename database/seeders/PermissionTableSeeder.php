<?php

namespace Database\Seeders;

use App\Models\Interview;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            // 'product-list',
            // 'product-create',
            // 'product-edit',
            // 'product-delete',
            'assessment-list',
            'assessment-create',
            'assessment-edit',
            'assessment-delete',
            'question-list',
            'question-delete',
            'question-edit',
            'question-create',
            'job-list',
            'job-create',
            'job-edit',
            'job-delete',
            'salary-list',
            'salary-create',
            'salary-edit',
            'salary-delete',
            'location-list',
            'location-create',
            'location-edit',
            'location-delete',
            'interview-list',
            'interview-create',
            'interview-edit',
            'interview-delete',
        ];
        foreach ($permissions as $permission) {
            // Check if the permission already exists
            if (!Permission::where('name', $permission)->where('guard_name', 'web')->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
            }
        }
    }
}
