<?php

namespace App\Helper;

use App\Models\StudyLog;
use Illuminate\Http\Request;

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
                'options' => [
                    StudyLog::DRAFT_STATUS => 'Chưa nộp, đang nháp',
                    StudyLog::PROCESS_STATUS => 'Đã gửi, chờ xác nhận',
                    StudyLog::COMMITTED_STATUS => 'Đã xác nhận xong, chờ duyệt',
                    StudyLog::ACCEPTED_STATUS => 'Đã duyệt',
                    StudyLog::CANCELLED_STATUS => 'Đã tự hủy',
                    StudyLog::REJECTED_STATUS => 'Từ chối duyệt',
                ],
                'bg' => [
                    StudyLog::DRAFT_STATUS => 'bg-primary',
                    StudyLog::PROCESS_STATUS => 'bg-orange',
                    StudyLog::COMMITTED_STATUS => 'bg-warning',
                    StudyLog::ACCEPTED_STATUS => 'bg-success',
                    StudyLog::CANCELLED_STATUS => 'bg-dark',
                    StudyLog::REJECTED_STATUS => 'bg-danger',
                ]
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'title',
            'label' => 'Tiêu đề buổi học'
        ]);
        $crudBag->addColumn([
            'name' => 'studylog_day',
            'label' => 'Ngày điểm danh'
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


        return $crudBag;
    }
}
