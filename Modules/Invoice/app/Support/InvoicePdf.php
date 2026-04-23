<?php

namespace Modules\Invoice\Support;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Course\Models\CourseOrder;

class InvoicePdf
{
    public static function download(CourseOrder $order, User $user)
    {
        return Pdf::loadView(
            'invoice::pdf.document',
            [
                'order' => $order,
                'user' => $user,
                'watermarkLogoDataUri' => static::watermarkLogoDataUri(),
            ]
        )
            ->setPaper('a4')
            ->download('invoice-' . $order->id . '.pdf');
    }

    private static function watermarkLogoDataUri(): ?string
    {
        $path = public_path('brand/itechbd-logo.svg');
        if (! is_file($path)) {
            return null;
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return null;
        }

        return 'data:image/svg+xml;base64,' . base64_encode($contents);
    }
}