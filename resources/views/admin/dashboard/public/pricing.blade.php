@extends('admin.dashboard.master')

@section('title','Pricing')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<section class="pricing-dark">

<!-- HERO -->
<div class="container text-center">
    <h1 class="display-5">
        Flexible Pricing for Every Business
    </h1>
    <p class="fs-4 text-muted mb-4">
        Scale your fleet with confidence
    </p>

    <!-- TOGGLE -->
    <div class="billing-toggle">
        <span class="toggle-label active" data-type="monthly">Monthly</span>
        <div class="toggle-switch" id="billingToggle"></div>
        <span class="toggle-label" data-type="yearly">
            Yearly <small>(Save 20%)</small>
        </span>
    </div>
</div>

<!-- PRICING -->
<div class="container">
<div class="row g-5 justify-content-center">
    @foreach($plans as $plan)
    <div class="col-lg-4">
        <div class="pricing-card dark {{ $plan->is_popular ? 'popular' : '' }}">
            @if($plan->is_popular)
            <span class="badge-popular">MOST POPULAR</span>
            @endif

            <h5 class="plan-name">{{ $plan->name }}</h5>

            <div class="price" 
                 data-monthly="{{ $plan->billing_cycle == 'monthly' ? $plan->price : 0 }}"
                 data-yearly="{{ $plan->billing_cycle == 'yearly' ? $plan->price : $plan->price * 12 }}">
                {{ $plan->price ? '৳' : '' }}<span>{{ $plan->price }}</span>
            </div>
            <div class="billing-text">
                {{ $plan->price ? 'per '.$plan->billing_cycle : 'Let’s Talk' }}
            </div>

            <ul class="features">
                @if($plan->features)
                    @foreach((array) $plan->features as $feature)
                        <li>✔ {{ $feature }}</li>
                    @endforeach
                @endif

                @if($plan->vehicle_limit)
                    <li>✔ Up to {{ $plan->vehicle_limit }} Vehicles</li>
                @endif
                @if($plan->user_limit)
                    <li>✔ {{ $plan->user_limit }} Users</li>
                @endif
            </ul>

            <a href="{{ $plan->price ? route('register') : '#' }}" 
               class="btn btn-{{ $plan->is_popular ? 'primary' : 'outline-light' }} w-100">
               <i class="fa fa-user-plus"></i>&nbsp;
               {{ $plan->price ? ($plan->is_popular ? 'Get Started' : 'Start Free Trial') : 'Contact Sales' }}
            </a>
            <a href="{{ route('subscription.select',$plan->slug) }}" class="btn btn-warning w-100">
            <i class="fa fa-check-circle"></i>&nbsp; Subscribe
            </a>
        </div>
    </div>
    @endforeach
</div>


</section>
</section>

<!-- STYLES -->
<style>
.pricing-dark {
    background: radial-gradient(circle at top, #111827, #020617);
    color: #fff;
    min-height: 100vh;
        margin-left: -30px;
}

.billing-toggle {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #020617;
    padding: 10px 20px;
    border-radius: 50px;
    border: 1px solid #1e293b;
}

.toggle-label {
    font-size: 1.1rem;
    cursor: pointer;
    color: #94a3b8;
}

.toggle-label.active {
    color: #fff;
    font-weight: 600;
}

.toggle-switch {
    width: 50px;
    height: 26px;
    background: #1e293b;
    border-radius: 20px;
    position: relative;
    cursor: pointer;
}

.toggle-switch::after {
    content: '';
    width: 20px;
    height: 20px;
    background: #0d6efd;
    border-radius: 50%;
    position: absolute;
    top: 3px;
    left: 4px;
    transition: .3s;
}

.toggle-switch.yearly::after {
    transform: translateX(22px);
}

.pricing-card.dark {
    background: linear-gradient(180deg, #020617, #020617);
    border: 1px solid #1e293b;
    border-radius: 18px;
    padding: 40px;
    text-align: center;
    height: 100%;
    box-shadow: 0 0 40px rgba(13,110,253,.15);
}

.pricing-card.popular {
    border: 2px solid #0d6efd;
    transform: scale(1.05);
}

.badge-popular {
    background: linear-gradient(90deg,#0d6efd,#6610f2);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .85rem;
    display: inline-block;
    margin-bottom: 15px;
}

.plan-name {
    font-size: 1.3rem;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.price {
    font-size: 3.2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.billing-text {
    color: #94a3b8;
    margin-bottom: 25px;
}

.features {
    list-style: none;
    padding: 0;
    text-align: left;
    font-size: 1.1rem;
}

.features li {
    margin-bottom: 12px;
}

.features .muted {
    color: #64748b;
}
</style>

<!-- SCRIPT -->
<script>
const toggle = document.getElementById('billingToggle');
const prices = document.querySelectorAll('.price');
const labels = document.querySelectorAll('.toggle-label');
let yearly = false;

toggle.addEventListener('click', () => {
    yearly = !yearly;
    toggle.classList.toggle('yearly');

    labels.forEach(l => l.classList.remove('active'));
    document.querySelector(`[data-type="${yearly ? 'yearly' : 'monthly'}"]`).classList.add('active');

    prices.forEach(p => {
        if (!p.dataset.monthly) return;
        p.querySelector('span').innerText = yearly ? p.dataset.yearly : p.dataset.monthly;
        p.nextElementSibling.innerText = yearly ? 'per year' : 'per month';
    });
});
</script>

@endsection
