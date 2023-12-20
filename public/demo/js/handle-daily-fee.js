const dailyInput = $("#daily_fee")
const dailyTotalDaysInput = $("#total_days")
const dailyTotalFeeInput = $("#total_fee")

const calculateDailyInput = () => {
    console.log('calculate', dailyTotalFeeInput.val().replace(/,/g, ''), dailyTotalDaysInput.val().replace(/,/g, ''))
    const dailyDay = (parseInt(dailyTotalFeeInput.val().replace(/,/g, '') || 0)) / (parseInt(dailyTotalDaysInput.val().replace(/,/g, '') || 1))
    console.log('daily', dailyDay)
    dailyInput.val(dailyDay.toLocaleString())
}

originalDaysInput.keyup(() => {
    calculateDailyInput()
})
originalFeeInput.keyup(() => {
    calculateDailyInput()
})

promoteFeeInput.keyup(() => {
    calculateDailyInput()
})

bonusDaysInput.keyup(() => {
    calculateDailyInput()
})
//*******************************************************************************************************

