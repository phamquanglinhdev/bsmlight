const promotePercentInput = $("#promotion-percent")
const originalFeeInputForPercent = $("#original_fee")
const promoteFeeInputForPercent = $("#promotion_fee")
const calculatePercent = () => {
    const promoPercent = ((parseInt(promoteFeeInputForPercent.val().replace(/,/g, '') || 0)) / (parseInt(originalFeeInputForPercent.val().replace(/,/g, '') || 0))) * 100
    promotePercentInput.val(promoPercent.toLocaleString())
}

originalFeeInputForPercent.keyup(() => {
    calculatePercent()
})
promoteFeeInputForPercent.keyup(() => {
    calculatePercent()
})

