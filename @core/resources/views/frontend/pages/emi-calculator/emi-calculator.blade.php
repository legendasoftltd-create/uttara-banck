@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('emi_calculator_page_'.$user_select_lang_slug.'_name') ?? __('EMI Calculator') }}
@endsection
@section('page-title')
    {{ get_static_option('emi_calculator_page_'.$user_select_lang_slug.'_name') ?? __('EMI Calculator') }}
@endsection

<style>
    .text-brand-blue {
        color: #188c47 !important;
    }

    .bg-brand-blue {
        background-color: #188c47 !important;
        border-color: #188c47 !important;
    }

    .bg-brand-blue:hover {
        background-color: #127a3b !important;
        border-color: #127a3b !important;
    }

    .calculator-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
    }

    .form-label {
        color: #4A5568;
        font-size: 15px;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        font-size: 15px;
        padding: 10px 16px;
        border-radius: 4px;
        border-color: #ced4da;
        color: #2d3748;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #188c47;
        box-shadow: 0 0 0 0.25rem rgba(24, 140, 71, 0.15);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
        box-shadow: none;
    }

    .field-error {
        display: none;
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .field-error.show {
        display: block;
    }

    .btn-brand {
        font-size: 15px;
        font-weight: 500;
        padding: 10px 24px;
        border-radius: 4px;
        transition: all 0.15s ease-in-out;
    }

    .disclaimer-text {
        color: #4A5568;
        font-size: 14px;
        line-height: 1.6;
    }

    .result-card {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transform: translateY(10px);
        transition: opacity 0.3s ease, transform 0.3s ease, max-height 0.4s ease;
        border-radius: 10px;
    }

    .result-card.show-active {
        opacity: 1;
        max-height: 500px;
        transform: translateY(0);
    }

    .result-loan {
        font-size: 15px;
        color: #4A5568;
        margin-bottom: 12px;
    }

    .result-loan span {
        font-weight: 600;
        color: #2d3748;
    }

    .result-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        font-size: 14px;
        color: #4A5568;
    }

    .result-row:last-child {
        border-bottom: none;
    }

    .result-row .label {
        font-weight: 500;
    }

    .result-row .value {
        font-weight: 700;
        font-size: 15px;
        color: #188c47;
    }

    .result-row.monthly-emi .value {
        font-size: 20px;
        color: #188c47;
    }

    .emi-calculator-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
</style>

@section('content')

<div class="d-flex flex-column align-items-center justify-content-center min-vh-screen p-4">

    <div class="w-full" style="max-width: 700px;">
        <h2 class="text-brand-blue text-center font-bold text-uppercase tracking-wide mb-4"
            style="font-size: 28px; letter-spacing: 0.5px;">
            EMI Calculator
        </h2>

        <div class="calculator-card p-4 p-md-5 mb-4">
            <form id="emiForm" onsubmit="event.preventDefault();">

                <!-- Row 1: Principal Loan Amount | Installment Type -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="loan_amount" class="form-label">
                            Principal Loan Amount <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            id="loan_amount"
                            class="form-control"
                            placeholder="Enter Loan Amount"
                            min="1"
                            required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="installment_type" class="form-label">
                            Installment Type <span class="text-danger">*</span>
                        </label>
                        <select id="installment_type" class="form-select" required>
                            <option value="monthly" selected>Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="half_yearly">Half Yearly</option>
                            <option value="yearly">Yearly</option>
                            <option value="annually">Annually</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: No of Installment | Rate of Interest -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="installment_count" class="form-label">
                            No of Installment <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            id="installment_count"
                            class="form-control"
                            placeholder="e.g. 60"
                            min="1"
                            required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="interest_rate" class="form-label">
                            Rate of Interest (%) <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            id="interest_rate"
                            class="form-control"
                            placeholder="e.g. 10.00"
                            required>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="emi-calculator-actions">
                    <button
                        type="button"
                        id="calculateBtn"
                        class="btn btn-primary bg-brand-blue btn-brand border-0">
                        Calculate
                    </button>
                    <button
                        type="button"
                        id="resetBtn"
                        class="btn btn-secondary btn-brand px-4">
                        Reset
                    </button>
                </div>

            </form>
        </div>

        <!-- Result Card -->
        <div id="resultCard" class="result-card card border-0 p-4 mb-4"
             style="background: linear-gradient(135deg, #f0faf4 0%, #e6f7ec 100%); border: 1px solid #b7e4c7 !important;">

            <div class="result-loan">
                Loan Amount <span id="displayLoan">Tk. 0</span>
            </div>

            <div class="result-row monthly-emi">
                <span class="label">Installment Amount</span>
                <span class="value" id="displayEmi">Tk. 0.00</span>
            </div>

            <div class="result-row">
                <span class="label text-danger">Total Interest Payable</span>
                <span class="value" id="displayInterest">Tk. 0.00</span>
            </div>

            <div class="result-row">
                <span class="label">Total Payment (Principal + Interest)</span>
                <span class="value" id="displayTotal">Tk. 0.00</span>
            </div>

        </div>

        <p class="disclaimer-text mb-0">
            <strong>Disclaimer:</strong> "EMI amount calculated here may vary marginally from the actual amount depending on exact disbursement date and bank policies."
        </p>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const loanAmountInput      = document.getElementById('loan_amount');
        const interestInput        = document.getElementById('interest_rate');
        const installmentTypeSelect = document.getElementById('installment_type');
        const installmentCountInput = document.getElementById('installment_count');

        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn     = document.getElementById('resetBtn');
        const emiForm      = document.getElementById('emiForm');

        const resultCard      = document.getElementById('resultCard');
        const displayLoan     = document.getElementById('displayLoan');
        const displayEmi      = document.getElementById('displayEmi');
        const displayInterest = document.getElementById('displayInterest');
        const displayTotal    = document.getElementById('displayTotal');

        const formatTk = (amount) => {
            return 'Tk. ' + parseFloat(amount).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        const formatTkWhole = (amount) => {
            return 'Tk. ' + parseFloat(amount).toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        };

        const getPeriodsPerYear = (type) => {
            switch (type) {
                case 'monthly':     return 12;
                case 'quarterly':   return 4;
                case 'half_yearly': return 2;
                case 'yearly':      return 1;
                case 'annually':    return 1;
                default:            return 12;
            }
        };

        const calculateEMI = () => {
            const principal = parseFloat(loanAmountInput.value);
            const annualRate = parseFloat(interestInput.value);
            const installmentType = installmentTypeSelect.value;
            const n = parseFloat(installmentCountInput.value);

            if (!principal || principal <= 0 || !annualRate || annualRate <= 0 || !n || n <= 0) {
                hideResult();
                return;
            }

            const periodsPerYear = getPeriodsPerYear(installmentType);
            const ratePerPeriod = annualRate / periodsPerYear / 100;

            let emi = 0;
            if (ratePerPeriod === 0) {
                emi = principal / n;
            } else {
                const factor = Math.pow(1 + ratePerPeriod, n);
                emi = principal * ratePerPeriod * factor / (factor - 1);
            }

            const totalPayment  = emi * n;
            const totalInterest = totalPayment - principal;

            displayLoan.textContent     = formatTkWhole(principal);
            displayEmi.textContent      = formatTk(emi);
            displayInterest.textContent = formatTk(totalInterest);
            displayTotal.textContent    = formatTk(totalPayment);

            showResult();
        };

        const showResult = () => {
            resultCard.classList.add('show-active');
        };

        const hideResult = () => {
            resultCard.classList.remove('show-active');
        };

        calculateBtn.addEventListener('click', () => {
            if (emiForm.checkValidity()) {
                calculateEMI();
            } else {
                emiForm.reportValidity();
            }
        });

        resetBtn.addEventListener('click', () => {
            emiForm.reset();
            hideResult();
        });

    });
</script>

@endsection