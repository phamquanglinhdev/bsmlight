<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @author Phạm Quang Linh <linhpq@getflycrm.com>
 * @since 11:41 am 20/12/2023
 *
 * @property string $uuid
 * @property int $van
 * @property string $van_date
 * @property string $student_id
 * @property string $classroom_id
 * @property string $classroom_type
 * @property string $commitment
 * @property string $drive_link
 * @property string $fee_reason
 * @property string $bonus_reason
 * @property integer $card_status
 * @property string $payment_plan
 *
 *
 * @property int $original_days # số buổi đăng ký gốc
 * @property int $bonus_days # Số buổi được tặng thêm
 * @property int $original_fee # Học phí gốc
 * @property int $promotion_fee # Học phí ưu đãi
 * @property string $paid_fee # Học phí đã thanh toán
 * @property int $attended_days # Số buổi bị trừ khi điểm danh
 *
 * @property $total_days = $original_days + $bonus_days  # Tổng số buổi học đăng ký
 * @property $total_fee = $original_fee - $promotion_fee # Tổng học phí cần thanh toán
 * @property $daily_fee = $total_fee / $total_days # Đơn giá một buổi
 * @property $can_use_day_by_paid  = $paid_fee / $total_fee * $total_days # Số buổi đc sử dụng theo thanh toán
 * @property $unpaid_fee = $total_fee - $paid_fee # Số tiền chưa thanh toán
 * @property $can_use_day = $can_use_day_by_paid - $van - $attended_days # Sổ buổi còn lại có thể được sử dụng => phân loại renew
 * @property $can_use_fee = $can_use_day * $daily_fee  # Số học phí còn lại có thể sử dụng
 * @property int $feedback_score Điểm feedback
 * @property string $latest_feedback_date  Ngày tháng năm lấy feedback
 * @property $sale_status Trạng thái tiến độ sale
 * @property $sale_updated_at Ngày tháng năm cập nhật sale
 *
 *
 */
class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_ACTIVE = 0;
    const STATUS_STOP = 1;
    const STATUS_STORE = 2;
    protected $table = 'cards';
    protected $guarded = ['id'];

    public function Student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public static function generateUUID($branch): string
    {
        $cardId = Card::query()->orderBy('id', 'desc')->first()?->id ?? 0;

        $uuid = $cardId < 1000
            ? sprintf('%04d', $cardId + 1)
            : sprintf('%07d', $cardId + 1);

        return $branch . "-" . "StudyCard" . "." . $uuid;
    }

    protected $appends = [
        'attended_days',
        'total_days',
        'total_fee',
        'daily_fee',
        'can_use_day_by_paid',
        'unpaid_fee',
        'can_use_day',
        'can_use_fee',
        'feedback_score',
        'latest_feedback_date',
        'sale_status',
        'sale_updated_at',
        'student_entity',
        'classroom_entity',
        'van_and_attended_days',
        'renew_type'
    ];


    /**
     * switch $this->can_use_day
     * <0 buổi = SOS: màu đỏ
     * =0 buổi = X: màu nâu
     * 0-6 buổi = A: màu tím
     * 7-12 buổi = B: màu xanh lá
     * 13-24 buổi = C: màu xanh lá nhạt
     * 25-48 buổi = D: màu xám
     * >48 buổi = E: màu trắng
     * @return string
     */
    public function getRenewTypeAttribute(): string
    {
        if ($this->can_use_day < 0) {
            return 'SOS';
        }
        if ($this->can_use_day == 0) {
            return 'X';
        }
        if ($this->can_use_day > 0 && $this->can_use_day <= 6) {
            return 'A';
        }
        if ($this->can_use_day > 6 && $this->can_use_day <= 12) {
            return 'B';
        }
        if ($this->can_use_day > 12 && $this->can_use_day <= 24) {
            return 'C';
        }
        if ($this->can_use_day > 24 && $this->can_use_day <= 48) {
            return 'D';
        }

        return 'E';
    }

    public function getVanAndAttendedDaysAttribute(): int
    {
        return $this->van + $this->attended_days;
    }

    public function getStudentEntityAttribute(): ?array
    {
        $student = $this->Student()?->first() ?? null;
        if (!$student) {
            return null;
        }

        return [
            'id' => $student->id,
            'name' => $student->name,
            'uuid' => $student->uuid,
            'avatar' => $student->avatar
        ];
    }

    public function getClassroomEntityAttribute(): ?array
    {

        $classroom = $this->Classroom()?->first() ?? null;
        if (!$classroom) {
            return null;
        }
        return [
            'id' => $classroom->id,
            'name' => $classroom->name,
            'uuid' => $classroom->uuid,
            'avatar' => $classroom->avatar
        ];
    }

    public function getAttendedDaysAttribute(): int
    {
        return CardLog::query()->where('card_id', $this->id)->where('status', CardLog::VERIFIED)->count();
    }

    public function getTotalDaysAttribute(): int
    {
        return $this->original_days + $this->bonus_days;
    }

    public function getTotalFeeAttribute(): int
    {
        return $this->original_fee - $this->promotion_fee;
    }

    public function getDailyFeeAttribute(): float|int
    {
        return $this->total_fee / ($this->total_days!=0 ? $this->total_days : 1);
    }

    public function getCanUseDayByPaidAttribute(): float|int
    {
        if ($this->total_fee == 0) {
            return 0;
        }

        return ($this->paid_fee / $this->total_fee) * $this->total_days;
    }

    public function getUnpaidFeeAttribute()
    {
        return $this->total_fee - $this->paid_fee;
    }

    public function getCanUseDayAttribute()
    {
        return $this->can_use_day_by_paid - $this->van - $this->attended_days;
    }

    public function getCanUseFeeAttribute(): float|int
    {
        return $this->can_use_day * $this->daily_fee;
    }

    public function getFeedbackScoreAttribute(): int
    {
        return 0;
    }

    public function getLatestFeedbackDateAttribute()
    {
        return null;
    }

    public function getSaleStatusAttribute()
    {
        return null;
    }

    public function getSaleUpdatedAtAttribute()
    {
        return null;
    }

    public function Classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }


    /**
     * Mã thẻ học + Trạng thái thẻ học $uuid + $card_status
     * Học sinh được thụ hưởng (mã, ảnh , tên, tên tiếng anh) $student_id
     * Lớp đang được xếp (mã , ảnh, tên ) $classroom_id
     * Tổng số buổi đăng ký $total_days
     * Tổng số tiền cần thanh toán $total_fee
     * Đơn giá một buổi $daily_fee
     * Tổng số tiền đã thanh toán $paid_fee
     * Số buổi được sử dụng theo thanh toán $can_use_day_by_paid
     * Số tiền chưa thanh toán $unpaid_fee
     * Van và số buổi bị trừ khi điểm danh $van + $attended_days
     * Số buổi còn lại có thể sử dụng $can_use_day
     *  Phân loại renew $renew_type
     * Số học phí còn lại có thể sử dụng $can_use_fee
     * Điểm feedback $feedback_score
     *  Ngày tháng năm lấy feedback $latest_feedback_date
     * Trạng thái tiến độ sale $sale_status
     * Ngày tháng năm cập nhật sale  $sale_updated_at
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('branch',function (Builder $builder) {
            $builder->where('branch',Auth::user()->{'branch'});
        });
    }
}
