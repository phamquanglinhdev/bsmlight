const totalFeeInput = $("#total_fee")
const originalFeeInput = $("input[name=original_fee]")
const promoteFeeInput = $("input[name=promotion_fee]")

const calculateTotalFeeInput = () => {
    const totalFee = (parseInt(originalFeeInput.val().replace(/,/g, '') || 0)) - (parseInt(promoteFeeInput.val().replace(/,/g, '') || 0))
    totalFeeInput.val(totalFee.toLocaleString())
}

originalFeeInput.keyup(() => {
    calculateTotalFeeInput()
})
promoteFeeInput.keyup(() => {
    calculateTotalFeeInput()
})

