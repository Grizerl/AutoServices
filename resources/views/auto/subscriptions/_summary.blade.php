<div class="thanks-card">
   <div class="thanks-card__icon"><i class="fa-solid fa-circle-check"></i></div>
   <h2>Thank you, {{ \Illuminate\Support\Str::of($subscription->name)->before(' ') }}!</h2>
   <p class="thanks-card__lead">Your subscription request has been received. A manager will call you shortly to confirm the details.</p>

   <p class="thanks-card__ref">Your request number <strong>{{ $subscription->reference }}</strong></p>

   <dl class="spec-table">
      <div><dt>Plan</dt><dd>{{ $subscription->plan_name }}</dd></div>
      <div><dt>Billing</dt><dd>{{ $subscription->period_label }}</dd></div>
      <div><dt>Price</dt><dd>${{ number_format($subscription->price) }} / {{ $subscription->billing_period === 'yearly' ? 'year' : 'month' }}</dd></div>
      <div><dt>Car</dt><dd>{{ $subscription->car }}</dd></div>
      <div><dt>Status</dt><dd><span class="badge-pill badge-pill--reserved">{{ $subscription->status_label }}</span></dd></div>
   </dl>

   <h3>What happens next</h3>
   <ol class="next-steps">
      <li>We call you at the number you provided to confirm the plan.</li>
      <li>We agree the start date and how you would like to pay.</li>
      <li>Your subscription becomes active and you can book your first visit.</li>
   </ol>

   <div class="thanks-card__actions">
      <a class="btn-car" href="{{ route('home_auto') }}">Back to home</a>
      <a class="btn-car btn-car--ghost" href="{{ route('offer') }}">Browse cars for sale</a>
   </div>
</div>
