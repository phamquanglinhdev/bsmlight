<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function getInitPermissions(): array
    {
        return [
            [
                'name' => 'Thêm mới học sinh',
                'key' => 'create student',
                'module' => 'student',
            ],
            [
                'name' => 'Danh sách học sinh',
                'key' => 'list student',
                'module' => 'student',
            ],
            [
                'name' => 'Chỉnh sửa học sinh',
                'key' => 'edit student',
                'module' => 'student',
            ],
            [
                'name' => 'Xem chi tiết học sinh',
                'key' => 'show student',
                'module' => 'student',
            ],
            [
                'name' => 'Xoá học sinh',
                'key' => 'delete student',
                'module' => 'student',
            ],
            [
                'name' => 'Danh sách chi nhánh',
                'key' => 'list branch',
                'module' => 'branch'
            ],
            [
                'name' => 'Thêm mới chi nhánh',
                'key' => 'create branch',
                'module' => 'branch'
            ],
            [
                'name' => 'Truy cập chi nhánh',
                'key' => 'access branch',
                'module' => 'branch'
            ],
            [
                'name' => 'Chỉnh sửa chi nhánh',
                'key' => 'edit branch',
                'module' => 'branch'
            ],
            [
                'name' => 'Xoá chi nhánh',
                'key' => 'delete branch',
                'module' => 'branch'
            ],

        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        foreach ($this->getInitPermissions() as $permission) {
            DB::table("permissions")->insert($permission);
        }
    }
}
