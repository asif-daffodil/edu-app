<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseOrder;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page for a selected course.
     */
    public function show(Course $course): View
    {
        abort_unless($course->status === 'active', 404);

        $amount = $this->courseAmount($course);

        return view('pages.checkout', compact('course', 'amount'));
    }

    /**
     * Create a pending order for the selected course.
     */
    public function store(Request $request, Course $course): RedirectResponse
    {
        abort_unless($course->status === 'active', 404);

        $userId = (int) Auth::id();
        abort_unless($userId > 0, 403);

        $amount = $this->courseAmount($course);

        $existing = CourseOrder::query()
            ->where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->orderByDesc('id')
            ->first();

        if ($existing) {
            return redirect()->route('checkout.success', $existing);
        }

        $order = CourseOrder::query()->create([
            'user_id' => $userId,
            'course_id' => $course->id,
            'amount' => $amount,
            'currency' => 'BDT',
            'status' => 'pending',
        ]);

        return redirect()->route('checkout.success', $order);
    }

    /**
     * Show checkout success / order summary page.
     */
    public function success(CourseOrder $order): View
    {
        $userId = (int) Auth::id();
        abort_unless($userId > 0, 403);
        abort_unless((int) $order->user_id === $userId, 403);

        $order->load('course');

        return view('pages.checkout-success', compact('order'));
    }

    private function courseAmount(Course $course): float
    {
        $discount = $course->discount_price;
        if (!is_null($discount)) {
            return (float) $discount;
        }

        $old = $course->old_price;
        if (!is_null($old)) {
            return (float) $old;
        }

        return 0.0;
    }
}
