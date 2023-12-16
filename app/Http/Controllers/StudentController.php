<?php

namespace App\Http\Controllers;

use App\DataTransferObject\StudentObject;
use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function create(): View
    {
        $this->crudBag->setEntity('student');
        $this->crudBag->setLabel('Học sinh');
        $this->crudBag->setAction('student.store');
        $this->crudBag->addFields([
            'name' => 'avatar',
            'type' => 'avatar-select',
            'required' => false,
            'label' => 'Chọn avatar',
            'options' => [
                0 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS0Oi53Y0SYUnNZ6FDFALWjbzr2siFFZqRAI_ygcnbVunsa0Ywsn1u1xGx7FisdgzGdcQ&usqp=CAU',
                1 => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFrh7xFLdXWAgC4xrL9rtaOMMI1W_ifWqbMzlvWwjSiNg1QRSpe6XwNEalJXfoNUaVHt8&usqp=CAU',
                3 => 'https://png.pngtree.com/png-clipart/20231002/original/pngtree-santa-smiling-face-with-red-hat-say-hohoho-png-image_13063768.png',
                4 => 'https://dthezntil550i.cloudfront.net/9m/latest/9m2306211009227300024981607/1280_960/7e11d8f6-5a3f-4121-8a4f-57653520ae98.png',
                5 => 'https://i.pinimg.com/originals/4a/5f/a7/4a5fa77ce26719459ecaab07353ef645.png',
                6 => 'https://static-cdn.jtvnw.net/jtv_user_pictures/f275797c-e631-4a89-b7d2-952c3a79c789-profile_image-300x300.png',
            ],
            'class' => 'col-10 mb-3'
        ]);

        $this->crudBag->addFields([
            'name' => 'name',
            'type' => 'text',
            'required' => true,
            'label' => 'Tên học sinh'
        ]);

        $this->crudBag->addFields([
            'name' => 'english_name',
            'type' => 'text',
            'required' => false,
            'label' => 'Tên tiếng anh'
        ]);

        $this->crudBag->addFields([
            'name' => 'status',
            'type' => 'select',
            'required' => true,
            'label' => 'Trạng thái',
            'options' => [
                0 => 'Đang học',
                1 => 'Đã nghỉ',
                2 => 'Đang bảo lưu'
            ]
        ]);

        $this->crudBag->addFields([
            'name' => 'gender',
            'type' => 'select',
            'required' => true,
            'label' => 'Giới tính',
            'options' => [
                0 => 'Nam',
                1 => 'Nữ',
            ]
        ]);

        $this->crudBag->addFields([
            'name' => 'birthday',
            'type' => 'date',
            'required' => false,
            'label' => 'Ngày sinh',
        ]);
        $this->crudBag->addFields([
            'name' => 'phone',
            'type' => 'phone',
            'required' => false,
            'label' => 'Số điện thoại',
        ]);

        $this->crudBag->addFields([
            'name' => 'facebook',
            'type' => 'text',
            'required' => false,
            'label' => 'Link facebook của học sinh',
        ]);

        $this->crudBag->addFields([
            'name' => 'email',
            'type' => 'email',
            'required' => false,
            'label' => 'Email của học sinh',
        ]);

        $this->crudBag->addFields([
            'name' => 'address',
            'type' => 'address',
            'required' => false,
            'label' => 'Địa chỉ sinh sống',
        ]);

        $this->crudBag->addFields([
            'name' => 'school',
            'type' => 'text',
            'required' => false,
            'label' => 'Trường đang theo học',
        ]);

        $this->crudBag->addFields([
            'name' => 'user_ref',
            'type' => 'select',
            'required' => false,
            'label' => 'Người giới thiệu',
            'nullable' => true
        ]);

        return view('create', [
            'crudBag' => $this->crudBag
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'english_name' => 'string|nullable',
            'avatar' => 'string',
            'status' => 'integer|in:0,1,2|required',
            'gender' => 'integer|in:0,1|required',
            'facebook' => 'string|nullable',
            'email' => 'email|nullable',
            'address' => 'string|nullable',
            'school' => 'string|nullable',
            'user_ref' => 'integer|nullable',
            'phone' => 'string|nullable'
        ]);

        $dataToCreateStudent = $request->only([
            'name',
            'avatar',
            'email',
            'phone',
        ]);

        $dataToCreateProfile = $request->only([
            'english_name',
            'status',
            'gender',
            'facebook',
            'address',
            'school',
            'user_ref',
        ]);

        $dataToCreateStudent['uuid'] = User::newUuid("B.0001", "HS");
        $dataToCreateStudent['password'] = Hash::make('bsm123456@');
        $dataToCreateStudent['branch'] = $request->user()->branch ?? "B.0001";
        $dataToCreateStudent['role'] = User::STUDENT_ROLE;

        DB::transaction(function () use ($dataToCreateStudent, $dataToCreateProfile) {
            $user = User::query()->create($dataToCreateStudent);
            $dataToCreateProfile['user_id'] = $user['id'];
            StudentProfile::query()->create($dataToCreateProfile);
        });

        return redirect('student/list')->with('success');
    }

    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setEntity('student');
        $crudBag->setLabel('Học sinh');
        $crudBag->addColumn([
            'name' => 'uuid',
            'type' => 'text',
            'label' => 'Mã học sinh'
        ]);
        $crudBag->addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Họ tên'
        ]);

        $crudBag->addColumn([
            'name' => 'english_name',
            'type' => 'text',
            'label' => 'Tên tiếng anh'
        ]);

        $crudBag->addColumn([
            'name' => 'cards',
            'type' => 'hasMany',
            'label' => 'Danh sách thẻ học',
            'attributes' => [
                'relation.id' => 'id',
                'relation.label' => 'uuid',
                'relation.entity' => 'card'
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'private_chat',
            'type' => 'link',
            'label' => 'Link Zalo Chăm sóc 1-1'
        ]);

        $crudBag->addColumn([
            'name' => 'gender',
            'type' => 'select',
            'label' => 'Giới tính',
            'attributes' => [
                'options' => [
                    Student::MALE => 'Nam',
                    Student::FEMALE => 'Nữ'
                ]
            ]
        ]);

//        $crudBag->addColumn([
//            'name' => 'birthday',
//            'type' => 'text',
//            'label' => 'Sinh nhật'
//        ]);
        $crudBag->addColumn([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Số điện thoại'
        ]);

        $crudBag->addColumn([
            'name' => 'facebook',
            'type' => 'link',
            'label' => 'Facebook'
        ]);

        $crudBag->addColumn([
            'name' => 'email',
            'type' => 'text',
            'label' => 'Email'
        ]);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator $students
         */
        $students = Student::query()->paginate(20);

        return \view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => new ListViewModel($students)
        ]);


    }
}
