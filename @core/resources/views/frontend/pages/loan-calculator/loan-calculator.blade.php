@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('loan_calculator_page_'.$user_select_lang_slug.'_name') ?? __('Deposit Calculator') }}
@endsection
@section('page-title')
    {{ get_static_option('loan_calculator_page_'.$user_select_lang_slug.'_name') ?? __('Deposit Calculator') }}
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

    /* FD Period: number input + dropdown side by side */
    .period-input-group {
        display: flex;
        gap: 8px;
    }

    .period-input-group input {
        flex: 1;
        min-width: 0;
    }

    .period-input-group select {
        width: 110px;
        flex-shrink: 0;
    }

    /* Result card */
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
        max-height: 400px;
        transform: translateY(0);
    }

    .result-invested {
        font-size: 15px;
        color: #4A5568;
        margin-bottom: 12px;
    }

    .result-invested span {
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

    .result-row.maturity .value {
        font-size: 20px;
        color: #188c47;
    }

    .loan-calculator-actions {
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
            Deposit Calculator
        </h2>

        <div class="calculator-card p-4 p-md-5 mb-4">
            <form id="fdForm" onsubmit="event.preventDefault();">

                <!-- Row 1: FD Amount | Rate of Interest -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="fd_amount" class="form-label">
                            FD Amount (Tk.) <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            id="fd_amount"
                            class="form-control"
                            placeholder="Enter FD Amount"
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
                            placeholder="e.g. 08.00"
                            required>
                        <div class="field-error" id="interestError">
                            Interest rate minimum 5 character
                        </div>
                    </div>
                </div>

                <!-- Row 2: FD Period | Compounding Frequency -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="fd_period" class="form-label">
                            FD Period <span class="text-danger">*</span>
                        </label>
                        <div class="period-input-group">
                            <input
                                type="number"
                                id="fd_period"
                                class="form-control"
                                placeholder="e.g. 12"
                                min="1"
                                required>
                            <select id="fd_period_unit" class="form-select">
                                <option value="days">Days</option>
                                <option value="months" selected>Months</option>
                                <option value="years">Years</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="compounding" class="form-label">
                            Compounding Frequency <span class="text-danger">*</span>
                        </label>
                        <select id="compounding" class="form-select" required>
                            <option value="simple">Simple Interest</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="half_yearly">Half Yearly</option>
                            <option value="yearly" selected>Yearly</option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="loan-calculator-actions">
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

            <div class="result-invested">
                You Invested <span id="displayInvested">Tk. 0</span>
            </div>

            <div class="result-row maturity">
                <span class="label ">Maturity Value</span>
                <span class="value" id="displayMaturity">Tk. 0.00</span>
            </div>

            <div class="result-row">
                <span class="label text-danger">Interest Earned</span>
                <span class="value" id="displayInterest">Tk. 0.00</span>
            </div>

        </div>

        <p class="disclaimer-text mb-0">
            <strong>Disclaimer:</strong> "Maturity amount calculated here may vary marginally from the actual amount depending on exact disbursement date and bank policies."
        </p>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const fdAmountInput    = document.getElementById('fd_amount');
        const interestInput    = document.getElementById('interest_rate');
        const periodInput      = document.getElementById('fd_period');
        const periodUnitSelect = document.getElementById('fd_period_unit');
        const compoundingSelect = document.getElementById('compounding');
        const interestError    = document.getElementById('interestError');

        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn     = document.getElementById('resetBtn');
        const fdForm       = document.getElementById('fdForm');

        const resultCard       = document.getElementById('resultCard');
        const displayInvested  = document.getElementById('displayInvested');
        const displayMaturity  = document.getElementById('displayMaturity');
        const displayInterest  = document.getElementById('displayInterest');

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

        // Interest rate: must be at least 5 chars e.g. "08.00"
        const validateInterestRate = () => {
            const raw = interestInput.value.trim();
            if (raw.length > 0 && raw.length < 5) {
                interestInput.classList.add('is-invalid');
                interestError.classList.add('show');
                return false;
            }
            interestInput.classList.remove('is-invalid');
            interestError.classList.remove('show');
            return true;
        };

        // Convert period to years based on unit
        const getPeriodInYears = () => {
            const val  = parseFloat(periodInput.value);
            const unit = periodUnitSelect.value;
            if (!val || val <= 0) return 0;
            if (unit === 'days')   return val / 365;
            if (unit === 'months') return val / 12;
            return val; // years
        };

        const calculateFD = () => {
            if (!validateInterestRate()) {
                hideResult();
                return;
            }

            const principal    = parseFloat(fdAmountInput.value);
            const annualRate   = parseFloat(interestInput.value);
            const periodYears  = getPeriodInYears();
            const compounding  = compoundingSelect.value;

            if (!principal || principal <= 0 || !annualRate || annualRate <= 0 || !periodYears || periodYears <= 0) {
                hideResult();
                return;
            }

            const r = annualRate / 100;
            let maturity = 0;

            if (compounding === 'simple') {
                // Simple Interest: M = P(1 + r*t)
                maturity = principal * (1 + r * periodYears);
            } else {
                // Compound Interest: M = P(1 + r/n)^(n*t)
                let n = 1;
                if (compounding === 'monthly')     n = 12;
                if (compounding === 'quarterly')   n = 4;
                if (compounding === 'half_yearly') n = 2;
                if (compounding === 'yearly')      n = 1;
                maturity = principal * Math.pow(1 + r / n, n * periodYears);
            }

            const interestEarned = maturity - principal;

            displayInvested.textContent = formatTkWhole(principal);
            displayMaturity.textContent  = formatTk(maturity);
            displayInterest.textContent  = formatTk(interestEarned);

            showResult();
        };

        const showResult = () => {
            resultCard.classList.add('show-active');
        };

        const hideResult = () => {
            resultCard.classList.remove('show-active');
        };

        // Live validation for interest rate
        interestInput.addEventListener('input', validateInterestRate);

        // Calculate button
        calculateBtn.addEventListener('click', () => {
            if (fdForm.checkValidity()) {
                calculateFD();
            } else {
                fdForm.reportValidity();
            }
        });

        // Reset
        resetBtn.addEventListener('click', () => {
            fdForm.reset();
            interestInput.classList.remove('is-invalid');
            interestError.classList.remove('show');
            hideResult();
        });

    });
</script>

@endsection