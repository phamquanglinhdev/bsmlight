<?php

namespace App\Jobs;

use App\Models\Branch;
use App\Models\CustomFields;
use App\Models\Host;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ProcessWhenNewBranchCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $branchCode;
    private int $hostId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $branchCode,
        int $hostId,
    )
    {
        //
        $this->branchCode = $branchCode;
        $this->hostId = $hostId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleAddCustomFields();
        $this->handleWelcomeEmail();
    }

    private function handleAddCustomFields()
    {
        $host = Host::query()->where('id', $this->hostId)->first();

        if(! $host) {
            return;
        }

        $branch = Branch::query()->where('uuid', $this->branchCode)->where('host_id', $this->hostId);

        if(! $branch) {
            return;
        }

        $customFieldsTemplates = $this->getCustomFieldsTemplates();
        foreach ($customFieldsTemplates as $customFieldsTemplate) {
            $customFieldsTemplate['name'] = Str::slug($customFieldsTemplate['label']);
            $customFieldsTemplate['branch'] = $this->branchCode;
            CustomFields::query()->create($customFieldsTemplate);
        }
    }

    private function handleWelcomeEmail() {}

    private function getCustomFieldsTemplates(): array
    {
        return [
            [
                'label' => 'Mô tả sở thích, tính cách, mối quan tâm của học sinh',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXTAREA_TYPE,
            ],
            [
                'label' => 'Group zalo chăm sóc 1-1 học sinh',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Họ và tên mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Ngày sinh mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::DATE_TYPE,
            ],
            [
                'label' => 'SĐT mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Facebook mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Email mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::EMAIL_TYPE,
            ],
            [
                'label' => 'Nghề nghiệp mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Mô tả sở thích, tính cách, mối quan tâm của mẹ',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXTAREA_TYPE,
            ],


            [
                'label' => 'Họ và tên bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Ngày sinh bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::DATE_TYPE,
            ],
            [
                'label' => 'SĐT bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Facebook bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Email bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::EMAIL_TYPE,
            ],
            [
                'label' => 'Nghề nghiệp bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Mô tả sở thích, tính cách, mối quan tâm của bố',
                'entity_type' => CustomFields::ENTITY_STUDENT,
                'type' => CustomFields::TEXTAREA_TYPE,
            ],

            /**
             * Ngày sinh giáo viên
             * Facebook giáo viên
             * Group zalo chăm sóc 1-1 giáo viên
             * Ghi chú về bộ môn, trình độ, nhóm tuổi mà giáo viên dạy
             * Link drive tới folder chứa bằng cấp, chứng chỉ, ảnh và video của giáo viên
             * Địa chỉ thường trú giáo viên
             * Tên ngân hàng nhận lương giáo viên
             * Số tài khoản ngân hàng nhận lương giáo viên
             * Tên chủ tài khoản ngân hàng nhận lương giáo viên
             */

            [
                'label' => 'Ngày sinh giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::DATE_TYPE,
            ],
            [
                'label' => 'Facebook giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Group zalo chăm sóc 1-1 giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Ghi chú về bộ môn, trình độ, nhóm tuổi mà giáo là dạy',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXTAREA_TYPE,
            ],
            [
                'label' => 'Link drive tới folder chứa bằng cấp, chứng chỉ, ảnh và video của giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Địa chỉ thường trú giáo giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên ngân hàng nhận lương của giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Số tài khoản ngân hàng nhận lương giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên chủ tài khoản ngân hàng nhận lương giáo viên',
                'entity_type' => CustomFields::ENTITY_TEACHER,
                'type' => CustomFields::TEXT_TYPE,
            ],

            /**
             * Ngày sinh trợ giảng
             * Facebook trợ giảng
             * Group zalo chăm sóc 1-1 trợ giảng
             * Địa chỉ thường trú trợ giảng
             * Tên ngân hàng nhận lương trợ giảng
             * Số tài khoản ngân hàng nhận lương trợ giảng
             * Tên chủ tài khoản ngân hàng nhận lương trợ giảng
             *
             */
            [
                'label' => 'Ngày sinh trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::DATE_TYPE,
            ],
            [
                'label' => 'Facebook trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Group zalo chăm sóc 1-1 trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Địa chỉ thường trú trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên ngân hàng nhận lương của trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Số tài khoản ngân hàng nhận lương trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên chủ tài khoản ngân hàng nhận lương trợ giảng',
                'entity_type' => CustomFields::ENTITY_SUPPORTER,
                'type' => CustomFields::TEXT_TYPE,
            ],

            /**
             *  Ngày sinh nhân viên
             *  Facebook nhân viên
             *  Group zalo chăm sóc 1-1 nhân viên
             *  Địa chỉ thường trú nhân viên
             *  Tên ngân hàng nhận lương nhân viên
             *  Số tài khoản ngân hàng nhận lương nhân viên
             *  Tên chủ tài khoản ngân hàng nhận lương nhân viên
             */
            [
                'label' => 'Ngày sinh nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::DATE_TYPE,
            ],
            [
                'label' => 'Facebook nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Group zalo chăm sóc 1-1 nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Địa chỉ thường trú nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên ngân hàng nhận lương của nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Số tài khoản ngân hàng nhận lương nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
            [
                'label' => 'Tên chủ tài khoản ngân hàng nhận lương nhân viên',
                'entity_type' => CustomFields::ENTITY_STAFF,
                'type' => CustomFields::TEXT_TYPE,
            ],
        ];
    }
}
