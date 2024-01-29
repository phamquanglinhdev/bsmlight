<?php

namespace App\Helper;

use App\Models\CardLog;
use App\Models\StudyLog;
use App\Models\User;
use App\Models\WorkingShift;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class CrudBag
{
    /**
     * @var array
     */
    public array $fields = [];
    private string $label = '';
    private string $entity = '';
    private array $columns = [];
    private array $filters = [];
    private array $statistics = [];
    private ?string $searchValue = null;

    private bool $hasFile = false;

    public function isHasFile(): bool
    {
        return $this->hasFile;
    }

    public function setHasFile(bool $hasFile): void
    {
        $this->hasFile = $hasFile;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getSearchValue(): ?string
    {
        return $this->searchValue;
    }

    public function setSearchValue(string $searchValue = null): void
    {
        $this->searchValue = $searchValue;
    }

    /**
     * @return Statistic[]
     */
    public function getStatistics(): array
    {
        return $this->statistics;
    }

    /**
     * @return Filter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addFilter(array $data = []): void
    {
        $this->filters[] = new Filter($data);
    }

    public function addStatistic(array $data = []): void
    {
        $this->statistics[] = new Statistic($data);
    }

    private ?int $id = null;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    private string $action;

    /**
     * @param $data
     * @return void
     */
    public function addFields($data): void
    {
        $this->fields[] = new Fields($data);
    }

    /**
     * @return Fields[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function addColumn(array $data = []): void
    {
        $this->columns[] = new Column($data);
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    private array $params = [];

    public function setParam(string $key, mixed $value): void
    {
        $this->params[$key] = $value;
    }

    public function getParam(string $key)
    {
        return $this->params[$key] ?? null;
    }

    public function handleColumns(Request $request, CrudBag $crudBag): CrudBag
    {
        $crudBag->addColumn([
            'label' => 'ID Buổi học',
            'type' => 'text',
            'name' => 'supportId',
            'attributes' => [
                'show' => true,
                'entity' => 'studylog'
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'select',
            'attributes' => [
                'options' => StudyLog::statusListOptions(),
                'bg' => StudyLog::statusBackgroundOptions()
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'classroomEntity',
            'type' => 'entity',
            'label' => 'Lớp học',
            'entity' => 'classroomEntity',
            'attributes' => [
                'avatar' => 'avatar',
                'name' => 'name',
                'uuid' => 'uuid',
                'id' => 'id',
                'entity' => 'classroomEntity',
                'model' => 'classroom'
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'studylog_day',
            'label' => 'Ngày tháng năm buổi học'
        ]);
        $crudBag->addColumn([
            'name' => 'title',
            'label' => 'Tiêu đề buổi học'
        ]);
        $crudBag->addColumn([
            'name' => 'statistics',
            'type' => 'statistics',
            'label' => 'Thống kê buổi học',
            'attributes' => [
                'statistics_fields' => [
                    [
                        'name' => 'attendances',
                        'label' => 'Đi học',
                        'color' => 'text-success'
                    ],
                    [
                        'name' => 'left',
                        'label' => 'Vắng',
                        'color' => 'text-danger'
                    ],
                    [
                        'name' => 'calculated',
                        'label' => 'Trừ buổi',
                        'color' => 'text-success'
                    ],
                    [
                        'name' => 'not_calculated',
                        'label' => 'Không trừ buổi',
                        'color' => 'text-danger'
                    ]
                ]
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'teachers',
            'type' => 'array',
            'label' => 'Giáo viên',
        ]);
        $crudBag->addColumn([
            'name' => 'supporters',
            'type' => 'array',
            'label' => 'Trợ giảng'
        ]);

        return $crudBag;
    }

    public function handleQuery(Request $request, Builder $query): Builder
    {
        if (Auth::user()->{'role'} == User::HOST_ROLE) {
            $query->whereHas('classroom', function (Builder $builder) {
                $builder->where('branch', Auth::user()->{'branch'});
            })
                ->where('status', '!=', StudyLog::CANCELED);

            return $query;
        }

        $query->where(function (Builder $query) {
            $query->where('status', '!=', StudyLog::CANCELED)
                ->where(function (Builder $builder) {
                    $builder->where('created_by', Auth::user()->id)
                        ->orWhere(function (Builder $query) {
                            $query->whereHas('CardLogs', function (Builder $query) {
                                $query->where('student_id', Auth::user()->id);
                            })->orWhereHas('WorkingShifts', function (Builder $query) {
                                $query->where('teacher_id', Auth::user()->id)->orWhere('supporter_id', Auth::user()->id)
                                    ->orWhere('staff_id', Auth::user()->id);
                            });
                        })->orWhere(function (Builder $builder) {
                            $builder->whereHas('Classroom', function (Builder $classroom) {
                                $classroom->where('staff_id', Auth::id());
                            });
                        });
                });
        });

        return $query->orderBy('created_at','DESC');
    }
}
