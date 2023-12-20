const totalDaysInput = $("#total_days")
const originalDaysInput = $("input[name=original_days]")
const bonusDaysInput = $("input[name=bonus_days]")

const calculateTotalInput = () => {
    const totalDay = (parseInt(originalDaysInput.val().replace(/,/g, '') || 0)) + (parseInt(bonusDaysInput.val().replace(/,/g, '') || 0))
    console.log("jo", totalDay)
    totalDaysInput.val(totalDay.toLocaleString())
}

originalDaysInput.keyup(() => {
    calculateTotalInput()
})
bonusDaysInput.keyup(() => {
    calculateTotalInput()
})
//*******************************************************************************************************

