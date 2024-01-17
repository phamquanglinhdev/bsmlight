<?php

namespace App\Http\Controllers;

use App\Exports\StudentTemplate;
use App\Helper\CrudBag;
use App\Imports\StudentImport;
use App\Models\CustomFields;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function downloadTemplate(string $entity)
    {
        switch ($entity) {
            case CustomFields::ENTITY_STUDENT:
                return $this->downloadStudentTemplate();
            default:
                return redirect()->back()->with('success', 'Tính năng đang phát triển');
        }
    }

    private function downloadStudentTemplate()
    {
        $studentColumn = [
            'Tên học sinh',
            'Tên tiếng Anh',
            'Giới tính',
            'Ngày sinh',
            'Số điện thoại',
            'Link facebook học sinh',
            'Email của học sinh',
            'Địa chỉ sinh sống',
            'Trường đang theo học',
        ];

        $customFields = CustomFields::query()->where('branch', Auth::user()->{'branch'})->where('entity_type', CustomFields::ENTITY_STUDENT)->get()->pluck('label')->toArray();

        $studentColumn = array_merge($studentColumn, $customFields);

        $cardFields = [
            'Số buổi trước khi sử dụng BSM',
            'Ngày chốt điểm danh ở hệ thống cũ',
            'Link PDF đơn đăng ký',
            'Cam kết đầu ra',
            'Số buổi đăng ký gốc',
            'Số buổi tặng thêm',
            'Lý do tặng',
            'Học phí gốc',
            'Học phí ưu đãi',
            'Lý do ưu đãi',
            'Kế hoạch thanh toán',
            'Số tiền thực tế đã thanh toán'
        ];

        return Excel::download(new StudentTemplate($studentColumn, $cardFields), Str::random(4) . '-student-template.xlsx');
    }

    public function importView(string $entity): View|RedirectResponse
    {
        $crudBag = new CrudBag();

        switch ($entity) {
            case CustomFields::ENTITY_STUDENT:
                $crudBag->setLabel('Học sinh');
                $crudBag->setEntity(CustomFields::ENTITY_STUDENT);
                break;
            default:
                return redirect()->back()->with('success', 'Tính năng đang phát triển');
        }

        return \view('import', ['crudBag' => $crudBag]);
    }

    /**
     * @throws ValidationException
     */
    public function import(Request $request, string $entity): RedirectResponse
    {
        switch ($entity) {
            case CustomFields::ENTITY_STUDENT:
                $this->validate($request, [
                    'file' => 'file|required|mimes:xlsx'
                ]);
                return $this->importStudent($request->file('file'));
            default:
                return redirect()->back()->with('success', 'Tính năng đang phát triển');
        }
    }

    private function importStudent(UploadedFile $file): RedirectResponse
    {
        Excel::import(new StudentImport(), $file);

        return redirect('/student/list')->with('success', 'Import thành công');
    }
}
