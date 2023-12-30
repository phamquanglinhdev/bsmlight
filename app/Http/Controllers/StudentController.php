<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StudentController extends Controller
{
    private CrudBag $crudBag;

    public function __construct(CrudBag $crudBag)
    {
        $this->crudBag = $crudBag;
    }

    public function create(): View
    {
        if (!check_permission('create student')) {
            abort(403);
        }

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
            'value' => "0",
            'required' => true,
            'label' => 'Trạng thái',
            'options' => [
                "0" => 'Đang học',
                "1" => 'Đã nghỉ',
                "2" => 'Đang bảo lưu'
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
        if (!check_permission('create student')) {
            abort(403);
        }

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
            'address',
            'birthday'
        ]);

        $dataToCreateStudent['uuid'] = User::newUuid(Auth::user()->{"branch"}, "HS");
        $dataToCreateStudent['password'] = Hash::make('bsm123456@');
        $dataToCreateStudent['branch'] = $request->user()->branch;
        $dataToCreateStudent['role'] = User::STUDENT_ROLE;

        DB::transaction(function () use ($dataToCreateStudent, $dataToCreateProfile) {
            $user = User::query()->create($dataToCreateStudent);
            $dataToCreateProfile['user_id'] = $user['id'];
            StudentProfile::query()->create($dataToCreateProfile);
        });

        return redirect('student/list')->with('success', 'Thêm mới thành công');
    }

    public function list(Request $request): View
    {
        if (!check_permission('list student')) {
            abort(403);
        }
        $perPage = $request->get('perPage') ?? 10;
        $crudBag = new CrudBag();
        $crudBag->setEntity('student');
        $crudBag->setLabel('Học sinh');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);

        /**
         * @var LengthAwarePaginator $students
         */
        $builder = Student::query();

        $this->handleBuilder($builder, $crudBag);

        $students = $builder->paginate($perPage);

        return \view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => new ListViewModel($students)
        ]);


    }

    public function edit(int $id): View
    {
        if (!check_permission('edit student')) {
            abort(403);
        }
        $this->crudBag->setEntity('student');
        $this->crudBag->setLabel('Học sinh');
        $this->crudBag->setAction('student.update');
        $this->crudBag->setId($id);

        $student = Student::query()->where('id', $id)->firstOrFail();

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
            'value' => $student['avatar'],
            'class' => 'col-10 mb-3'
        ]);

        $this->crudBag->addFields([
            'name' => 'name',
            'type' => 'text',
            'required' => true,
            'label' => 'Tên học sinh',
            'value' => $student['name'],
        ]);

        $this->crudBag->addFields([
            'name' => 'english_name',
            'type' => 'text',
            'required' => false,
            'label' => 'Tên tiếng anh',
            'value' => $student['english_name'],
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
            ],
            'value' => $student['status'],
        ]);

        $this->crudBag->addFields([
            'name' => 'gender',
            'value' => $student['gender'],
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
            'value' => Carbon::parse($student['birthday'])->toDateString(),
            'type' => 'date',
            'required' => false,
            'label' => 'Ngày sinh',
        ]);
        $this->crudBag->addFields([
            'name' => 'phone',
            'value' => $student['phone'],
            'type' => 'phone',
            'required' => false,
            'label' => 'Số điện thoại',
        ]);

        $this->crudBag->addFields([
            'value' => $student['facebook'],
            'name' => 'facebook',
            'type' => 'text',
            'required' => false,
            'label' => 'Link facebook của học sinh',
        ]);

        $this->crudBag->addFields([
            'value' => $student['email'],
            'name' => 'email',
            'type' => 'email',
            'required' => false,
            'label' => 'Email của học sinh',
        ]);

        $this->crudBag->addFields([
            'value' => $student['address'],
            'name' => 'address',
            'type' => 'address',
            'required' => false,
            'label' => 'Địa chỉ sinh sống',
        ]);

        $this->crudBag->addFields([
            'value' => $student['school'],
            'name' => 'school',
            'type' => 'text',
            'required' => false,
            'label' => 'Trường đang theo học',
        ]);

        $this->crudBag->addFields([
            'value' => $student['user_ref'],
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

    public function update(int $id, Request $request): RedirectResponse
    {
        if (!check_permission('edit student')) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required|string',
            'english_name' => 'string|nullable',
            'avatar' => 'string|required',
            'status' => 'integer|in:0,1,2|required',
            'gender' => 'integer|in:0,1|required',
            'facebook' => 'string|nullable',
            'email' => 'email|nullable',
            'address' => 'string|nullable',
            'school' => 'string|nullable',
            'user_ref' => 'integer|nullable',
            'phone' => 'string|nullable',
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
            'address',
            'birthday'
        ]);

        DB::transaction(function () use ($dataToCreateStudent, $dataToCreateProfile, $id) {
            User::query()->where('id', $id)->update($dataToCreateStudent);

            StudentProfile::query()->where('user_id', $id)->update($dataToCreateProfile);
        });

        return redirect()->to('student/list')->with('success', 'Chỉnh sửa thành công');
    }

    public function delete(int $id): RedirectResponse
    {
        if (!check_permission('delete student')) {
            abort(403);
        }
        $student = Student::query()->where('id', $id)->firstOrFail();

        DB::transaction(function () use ($student) {
            StudentProfile::query()->where('user_id', $student->id)->delete();
            $student->delete();
        });

        return redirect()->back()->with('success', 'Xóa thành công');
    }

    private function handleFiltering(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addFilter([
            'label' => 'Trạng thái thẻ học',
            'name' => 'card_status:eq',
            'value' => $request->get('card_status:eq') ?? -1,
            'type' => 'select',
            'attributes' => [
                'options' => [
                    0 => 'Đang học',
                    1 => 'Bảo lưu',
                    2 => 'Đã kết thúc'
                ]
            ]
        ]);
        $crudBag->addFilter([
            'name' => 'gender:eq',
            'value' => $request->get('gender:eq') ?? -1,
            'label' => 'Giới tính',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    Student::MALE => 'Nam',
                    Student::FEMALE => 'Nữ'
                ]
            ],
        ]);

        $crudBag->addFilter([
            'name' => 'birthday_month:handle',
            'label' => 'Tháng sinh nhật',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    1 => 'Tháng 1',
                    2 => 'Tháng 2',
                    3 => 'Tháng 3',
                    4 => 'Tháng 4',
                    5 => 'Tháng 5',
                    6 => 'Tháng 6',
                    7 => 'Tháng 7',
                    8 => 'Tháng 8',
                    9 => 'Tháng 9',
                    10 => 'Tháng 10',
                    11 => 'Tháng 11',
                    12 => 'Tháng 12'
                ]
            ],
            'value' => $request->get('birthday_month:handle')
        ]);

        $crudBag->addFilter([
            'label' => 'Lớp học trên BSM',
            'name' => 'classroom:handle',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    1 => 'Lop C001',
                    2 => 'Lop C002'
                ]
            ],
            'value' => $request->get('classroom:handle')
        ]);

        $crudBag->addFilter([
            'label' => 'Lớp',
            'name' => 'grade:handle',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    1 => 'Lớp 1',
                    2 => 'Lớp 2',
                    3 => 'Lớp 3',
                    4 => 'Lớp 4',
                    5 => 'Lớp 5',
                    6 => 'Lớp 6',
                    7 => 'Lớp 7',
                    8 => 'Lớp 8',
                    9 => 'Lớp 9',
                    10 => 'Lớp 10',
                    11 => 'Lớp 11',
                    12 => 'Lớp 12',
                    13 => 'Cấp cao hơn'
                ],
            ],
            'value' => $request->get('grade:handle')
        ]);


        $crudBag->addFilter([
            'label' => 'Cấp học',
            'name' => 'level:handle',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    0 => 'Mầm non',
                    1 => 'Tiểu học',
                    2 => 'THCS',
                    3 => 'THPT',
                    4 => 'Cao Đẳng - Đại Học',
                    5 => 'Khác'
                ],
            ],
            'value' => $request->get('level:handle')
        ]);
        $crudBag->addFilter([
            'label' => 'Tuổi',
            'name' => 'age:eq',
            'type' => 'text',
            'value' => $request->get('age:eqe')
        ]);

        $crudBag->addFilter([
            'label' => 'Nhan vien phu trach',
            'name' => 'staff:handle',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    1 => 'Anh C',
                    2 => 'Anh B',
                ]
            ],
            'value' => $request->get('staff:handle')
        ]);

        return $crudBag;
    }

    private function handleBuilder(Builder $builder, CrudBag $crudBag): void
    {
        if ($crudBag->getSearchValue() !== '') {
            $builder->where(function (Builder $subBuilder) use ($crudBag) {
                $subBuilder->where('name', 'like', "%" . $crudBag->getSearchValue() . "%")
                    ->orWhere('uuid', 'like', '%' . $crudBag->getSearchValue() . '%');
            });
        }

        foreach ($crudBag->getFilters() as $filter) {
            if ($filter->getValue() !== null && $filter->getValue() != '-1') {
                switch ($filter->getName()) {
                    case "name:contains":
                        $builder->where('name', 'like', "%" . $filter->getValue() . "%");
                        break;
                    case "gender:eq":
                        $builder->whereHas('profile', function (Builder $profile) use ($filter) {
                            $profile->where('gender', $filter->getValue());
                        });
                        break;
                    case "birthday_month:handle":
                        $builder->whereHas('profile', function (Builder $profile) use ($filter) {
                            $profile->whereRaw('MONTH(birthday) = ' . $filter->getValue());
                        });
                        break;
                    default:
                        break;
                }
            }
        }

        $builder->orderBy('created_at', 'desc');
    }

    private function handleStatistic(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addStatistic([
            'label' => 'Học sinh',
            'value' => Student::query()->count(),
            'badge' => 'Thời điểm hiện tại',
            'image' => asset('demo/assets/img/illustrations/illustration-1.png')
        ]);

        $crudBag->addStatistic([
            'label' => 'Đang học',
            'value' => Student::query()->whereHas('profile', function (Builder $profile) {
                $profile->where('status', 0);
            })->count(),
            'badge' => 'Thời điểm hiện tại',
            'image' => asset('demo/assets/img/illustrations/illustration-1.png')
        ]);
        $crudBag->addStatistic([
            'label' => 'Đã ngừng học',
            'value' => Student::query()->whereHas('profile', function (Builder $profile) {
                $profile->where('status', 1);
            })->count(),
            'badge' => 'Thời điểm hiện tại',
            'image' => asset('demo/assets/img/illustrations/illustration-1.png')
        ]);
        $crudBag->addStatistic([
            'label' => 'Đang bảo lưu',
            'value' => Student::query()->whereHas('profile', function (Builder $profile) {
                $profile->where('status', 2);
            })->count(),
            'badge' => 'Thời điểm hiện tại',
            'image' => asset('demo/assets/img/illustrations/illustration-1.png')
        ]);

        return $crudBag;
    }

    private function handleColumn(CrudBag $crudBag, Request $request): CrudBag
    {
        $crudBag->addColumn([
            'name' => 'uuid',
            'type' => 'text',
            'label' => 'Mã học sinh',
            'fixed' => 'first'
        ]);
        $crudBag->addColumn([
            'name' => 'name',
            'type' => 'profile',
            'label' => 'Họ tên',
            'attributes' => [
                'avatar' => 'avatar',
                'address' => 'address',
                'identity' => 'id'
            ]
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
            'name' => 'zalo_private_chat',
            'type' => 'link',
            'label' => 'Link Zalo Chăm sóc 1-1'
        ]);

        $crudBag->addColumn([
            'name' => 'private_chat',
            'type' => 'link',
            'label' => 'Chat trên hệ thống'
        ]);

        $crudBag->addColumn([
            'name' => 'gender',
            'type' => 'select',
            'label' => 'Giới tính',
            'attributes' => [
                'options' => [
                    Student::MALE => 'Nam',
                    Student::FEMALE => 'Nữ'
                ],
                'bg' => [
                    Student::MALE => 'bg-danger',
                    Student::FEMALE => 'bg-success'
                ]
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'birthday',
            'type' => 'text',
            'label' => 'Ngày sinh'
        ]);
        $crudBag->addColumn([
            'name' => 'age',
            'type' => 'text',
            'label' => 'Tuổi',
            'attributes' => [
                'bg' => [
                    '1' => 'bg-success',
                    '2' => 'bg-success',
                    '3' => 'bg-success',
                    '4' => 'bg-success',
                    '5' => 'bg-success',
                    '6' => 'bg-warning',
                    '7' => 'bg-warning',
                    '8' => 'bg-warning',
                    '9' => 'bg-warning',
                    '10' => 'bg-warning',
                    '11' => 'bg-orange',
                    '12' => 'bg-orange',
                    '13' => 'bg-orange',
                    '14' => 'bg-orange',
                    '15' => 'bg-danger',
                    '16' => 'bg-danger',
                    '17' => 'bg-danger',
                    '18' => 'bg-purple',
                    '19' => 'bg-purple',
                    '20' => 'bg-purple',
                    '21' => 'bg-purple',
                ]
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'grade',
            'type' => 'text',
            'label' => 'Lớp',
            'attributes' => [
                'bg' => [
                    'Lớp 3 tuổi' => 'bg-success',
                    'Lớp 4 tuổi' => 'bg-success',
                    'Lớp 5 tuổi' => 'bg-success',
                    'Lớp 1' => 'bg-warning',
                    'Lớp 2' => 'bg-warning',
                    'Lớp 3' => 'bg-warning',
                    'Lớp 4' => 'bg-warning',
                    'Lớp 5' => 'bg-warning',

                    'Lớp 6' => 'bg-orange',
                    'Lớp 7' => 'bg-orange',
                    'Lớp 8' => 'bg-orange',
                    'Lớp 9' => 'bg-orange',
                    'Lớp 10' => 'bg-danger',
                    'Lớp 11' => 'bg-danger',
                    'Lớp 12' => 'bg-danger',
                    'Khác' => 'bg-purple',
                ]
            ]
        ]);

        $crudBag->addColumn([
            'name' => 'level',
            'type' => 'text',
            'label' => 'Cấp hoc',
            'attributes' => [
                'bg' => [
                    'Mầm non' => 'bg-success',
                    'Tiểu học' => 'bg-warning',
                    'THCS' => 'bg-orange',
                    'THPT' => 'bg-danger',
                    'Cao Đẳng - Đại Học' => 'bg-purple',
                    'Người đi làm' => 'bg-green',
                ]
            ]
        ]);

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

        $crudBag->addColumn([
            'name' => 'user_ref',
            'type' => 'text',
            'label' => 'Người giới thiệu',
        ]);

        $crudBag->addColumn([
            'name' => 'sibling',
            'type' => 'hasMany',
            'label' => 'Anh chị em',
            'attributes' => [
                'relation.id' => 'id',
                'relation.label' => 'uuid',
                'relation.entity' => 'student'
            ]
        ]);

        return $crudBag;
    }
}
