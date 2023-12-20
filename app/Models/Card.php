<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Phạm Quang Linh <linhpq@getflycrm.com>
 * @since 11:41 am 20/12/2023
 * @property string $uuid
 * @property int $van
 * @property string $van_date
 * @property string $student_id
 * @property string $classroom_id
 * @property string $classroom_type
 * @property string $commitment
 * @property string $drive_link
 * @property int $original_days
 * @property int $bonus_days
 * @property string $bonus_reason
 * @property int $original_fee
 * @property int $promotion_fee
 * @property string $fee_reason
 * @property string $payment_plan
 * @property string $paid_fee
 *
 * @property int $used_days,
 * @property int $attended_days
 * @property int $days
 * @property int $fee
 * @property int $promotion_percent_fee
 * @property int $daily_fee
 */
class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array
     * - Các fields được linh động tính ra
     * + Số buổi đã sử dụng = VAN + số buổi đã trừ khi điểm danh ( lấy từ điếm danh)
     * + Số buổi thực tế đăng ký = Số buổi đăng ký  gốc + số buổi tặng thêm
     * + Ưu đãi (%) : Ưu đãi / Học phí gốc
     * + Học phí thực tế cần thanh toán = Học phí gốc - Ưu đãi
     * + Đơn giá mỗi buổi học : Học phí thực tế cần thanh toán/Số buổi thực tế đăng ký
     */
    protected $appends = [
        'used_days',
        'attended_days',
        'days',
        'fee',
        'promotion_percent_fee',
        'daily_fee',
    ];

    #genarate accessor attribute from appends

    /**
     * @return int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getUsedDaysAttribute(): int
    {
        return $this->van + $this->attended_days;
    }

    /**
     * @return int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getAttendedDaysAttribute(): int
    {
        return 0;
    }

    /**
     * @return int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getDaysAttribute(): int
    {
        return $this->original_days + $this->bonus_days;
    }

    /**
     * @return int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getFeeAttribute(): int
    {
        return $this->original_fee - $this->promotion_fee;
    }

    /**
     * @return float|int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getPromotionPercentFeeAttribute()
    {
        return $this->promotion_fee / $this->original_fee * 100;
    }

    /**
     * @return float|int
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 20/12/2023 11:54 am
     */
    public function getDailyFeeAttribute()
    {
        return $this->fee / $this->days;
    }

}
