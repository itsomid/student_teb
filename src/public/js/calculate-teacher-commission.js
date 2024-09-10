const calculateSum = (productsArraySold) => {
    let sumStudents = 0;
    let sumBuyAmount = 0;
    let sumCashAmount = 0;

    let blockedTaxForUser = 0;
    let blockedTaxForClassino = 0;

    let sumPayments = 0;
    let sumNeedsToBePaid = 0;

    let sumBlockedForTax = 0;

    document.querySelectorAll('.sum_checkbox').forEach((checkbox) => {
        const value = checkbox.value; // Declare value outside the if-else block
        const paymentElement = document.getElementById(`payment_${value}`);

        if (checkbox.checked) {
            sumStudents += +productsArraySold[value].students;
            sumBuyAmount += +productsArraySold[value].buy_amount;
            sumCashAmount += +productsArraySold[value].cash_amount;
            sumPayments += +productsArraySold[value].payments_amount;

            const userPercentageTmp =
                parseFloat(document.getElementById(`product_percentage_${value}`)?.value) * 0.01 || 0;
            const blockedPercentageForTax =
                parseFloat(document.getElementById(`tax_percentage_${value}`)?.value) || 0;

            const blockedTmpTotal =
                productsArraySold[value].cash_amount * (blockedPercentageForTax / 100);
            sumBlockedForTax += blockedTmpTotal;

            blockedTaxForUser += blockedTmpTotal * userPercentageTmp;
            blockedTaxForClassino += blockedTmpTotal * (1 - userPercentageTmp);

            const myCashTmp =
                productsArraySold[value].cash_amount * (1 - blockedPercentageForTax / 100);
            sumNeedsToBePaid += userPercentageTmp * myCashTmp;

            if (paymentElement) {
                paymentElement.style.display = 'table-row';
            }
        } else {
            if (paymentElement) {
                paymentElement.style.display = 'none';
            }
        }
    });

    sumNeedsToBePaid = parseInt(sumNeedsToBePaid);
    const sumBlockedAmount = parseInt(sumBlockedForTax);

    document.getElementById('sum_students').textContent = `مجموع : ${sumStudents} نفر`;
    document.getElementById('sum_buy_amount').textContent = `مجموع : ${sumBuyAmount.toLocaleString()} ریال`;
    document.querySelectorAll('.sum_cash_amount').forEach((el) => {
        console.log(el)
        el.textContent = `مجموع : ${sumCashAmount.toLocaleString()} ریال`;
    });



    document.getElementById('sum_blocked_amount').textContent = `${sumBlockedAmount.toLocaleString()} ریال (استاد: ${parseInt(
        blockedTaxForUser
    ).toLocaleString()} ریال، کلاسیو: ${parseInt(blockedTaxForClassino).toLocaleString()} ریال)`;

    document.querySelectorAll('.sum_payments').forEach((el) => {
        el.textContent = `مجموع : ${sumPayments.toLocaleString()} ریال`;
    });

    document.getElementById('sum_needs_to_be_paid').textContent = `${sumNeedsToBePaid.toLocaleString()} ریال`;

    const tarazMaali = sumNeedsToBePaid - sumPayments;
    document.getElementById('taraz_maali').textContent = `${tarazMaali.toLocaleString()} ریال ${
        tarazMaali >= 0 ? 'بدهکار' : 'طلبکار'
    }`;
};
