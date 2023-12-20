<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * - Các fields phải lưu cứng
         * + Mã thẻ học
         * + VAN ( Số buổi được sử dụng trên thẻ trước khi dùng phần mềm)
         * + Ngày bắt đầu sử dụng BSM
         * + ID học sinh ( tham chiếu tới học sinh) => chọn học sinh
         * + ID lớp học ( tham chiếu tới lớp học) => chọn lớp học
         * + loại lớp được sử dụng
         * + ghi chú cam kết đầu ra
         * + link drive đơn đăng ký
         * + số buổi đăng ký gốc
         * + sô buổi được tặng thêm
         * + lý do tặng thêm
         * + học phí gốc
         * + ưu đãi
         * + lý do ưu đãi
         * + ghi chú kế hoạch thanh toán (nếu có)
         */

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('van')->default(0);
            $table->date('van_date')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('classroom_id')->nullable();
            $table->string('classroom_type')->nullable();
            $table->text('commitment')->nullable();
            $table->string('drive_link')->nullable();
            $table->integer('original_days');
            $table->integer('bonus_days')->default(0);
            $table->text('bonus_reason')->nullable();
            $table->integer('original_fee');
            $table->integer('promotion_fee')->default(0);
            $table->text('fee_reason')->nullable();
            $table->text('payment_plan')->nullable();
            $table->integer('paid_fee')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
