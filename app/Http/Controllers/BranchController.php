<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Branch;
use App\Models\Host;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function list(): View
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $crudBag = new CrudBag();
        $crudBag->setHasFile(true);
        $crudBag->setAction('branch.store');

        $crudBag->addFields([
            'name' => 'logo',
            'label' => 'Logo của trung tâm',
            'type' => 'upload',
        ]);
        $crudBag->addFields([
            'name' => 'name',
            'label' => 'Tên chi nhánh',
            'type' => 'text',
            'required' => true
        ]);

        $crudBag->addFields([
            'name' => 'description',
            'label' => 'Mô tả chi nhánh',
            'type' => 'textarea',
        ]);

        $crudBag->setLabel('Chi nhánh');

        $branches = Branch::query()->orderBy('last_active', "desc")->where('host_id', $user->id)->paginate(100);

        $listViewModel = new ListViewModel($branches);

        return view('branch.list', [
            'listViewModel' => $listViewModel,
            'crudBag' => $crudBag
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function access(int $branchId): RedirectResponse
    {

        $host = Host::query()->where('id', Auth::user()->{'id'})->first();

        if (!$host) {
            Auth::logout();
        }

        $branch = Branch::query()->where('id', $branchId)->where('host_id', $host->id)->first();

        if (!$branch) {
            return redirect()->back()->withErrors(['branch' => 'Chi nhánh không hợp lệ']);
        }

        $host->update([
            'branch' => $branch->uuid ?? "UNSELECTED"
        ]);

        $branch->update([
            'last_active' => Carbon::now()
        ]);

        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string|nullable',
            'logo' => 'file',
        ]);
        /**
         * @var UploadedFile $logoFile
         */
        $logoFile = $request->file('logo');

        $logo = uploads($logoFile);

        $dataForCreateBranch = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'uuid' => Branch::createNewUuid(),
            'host_id' => Auth::user()->{'id'},
            'last_active' => Carbon::now(),
            'logo' => $logo
        ];

        DB::transaction(fn() => Branch::query()->create($dataForCreateBranch));

        return redirect()->back()->with('success', "Thêm mới thành công");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
