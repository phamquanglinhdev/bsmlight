const dailyInput = $("#daily_fee")
const dailyTotalDaysInput = $("#total_days")
const dailyTotalFeeInput = $("#total_fee")

const calculateDailyInput = () => {
    const dailyDay = (parseInt(dailyTotalFeeInput.val().replace(/\./g, '').replace(/,/g, ''))) / (parseInt(dailyTotalDaysInput.val().replace(/\./g, '').replace(/,/g, '')))

    dailyInput.val(dailyDay.toLocaleString())
}

$("#original_fee").keyup(() => {
    calculateDailyInput()
})
$("#promotion_fee").keyup(() => {
    calculateDailyInput()
})
$("#original_days").keyup(() => {
    calculateDailyInput()
})
$("#bonus_days").keyup(() => {
    calculateDailyInput()
})
//*******************************************************************************************************

