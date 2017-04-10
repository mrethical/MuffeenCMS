<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inquiry;
use App\Repositories\Inquiries;
use App\Http\Controllers\Controller;

class InquiriesController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', Inquiry::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => Inquiries::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => Inquiries::getCount()
            ])
                ->header('Cache-Control', ' no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.inquiries.index');
    }

    public function destroy(Inquiry $inquiry)
    {
        $this->authorize('delete', $inquiry);

        $inquiry->delete();

        return response()->json(['success' => 'success']);
    }

}
