<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionUpdateRequest;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** Admin: subscription requests and active subscriptions. */
class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $status = array_key_exists((string) $request->query('status'), Subscription::STATUSES) ? $request->query('status') : null;

        return view('admin.subscriptions.index', [
            'subscriptions' => Subscription::query()
                ->when($status, fn ($q, $s) => $q->where('status', $s))
                ->latest('id')
                ->paginate(15)
                ->withQueryString(),
            'status' => $status,
        ]);
    }

    public function show(Subscription $subscription): View
    {
        return view('admin.subscriptions.show', ['subscription' => $subscription->load('plan')]);
    }

    public function update(SubscriptionUpdateRequest $request, Subscription $subscription): RedirectResponse
    {
        $data = $request->validated();

        $subscription->applyStatus(
            $data['status'],
            filled($data['starts_at'] ?? null) ? Carbon::parse($data['starts_at']) : null,
            filled($data['ends_at'] ?? null) ? Carbon::parse($data['ends_at']) : null,
        );

        return redirect()->route('subscriptions.show', $subscription)->with('success', 'The subscription has been updated.');
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'The subscription has been deleted.');
    }
}
