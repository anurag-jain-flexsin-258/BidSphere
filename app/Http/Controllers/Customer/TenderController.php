<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tender\StoreTenderRequest;
use App\Http\Requests\Tender\UpdateTenderRequest;
use App\Models\Tender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class TenderController
 *
 * Handles CRUD operations for customer tenders, including uploading images and attachments.
 *
 * @package App\Http\Controllers\Customer
 */
class TenderController extends Controller
{
    /**
     * Display a paginated listing of tenders for the authenticated customer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tenders = Tender::with(['categories', 'images', 'attachments'])
            ->where('customer_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.tenders.index', compact('tenders'));
    }

    /**
     * Show the form for creating a new tender.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('customer.tenders.create', compact('categories'));
    }

    /**
     * Store a newly created tender in storage.
     *
     * @param StoreTenderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTenderRequest $request)
    {
        DB::beginTransaction();

        try {
            // 1. Create Tender
            $tender = Tender::create([
                'customer_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'status' => $request->status ?? 'pending',
                'expires_at' => $request->expires_at,
                'is_featured' => $request->has('is_featured'),
            ]);

            // 2. Attach categories
            $tender->categories()->sync($request->categories ?? []);

            // 3. Save images
            if ($request->hasFile('images')) {
                /** @var \Illuminate\Http\UploadedFile $image */
                foreach ($request->file('images') as $image) {
                    // Store on the 'public' disk under tenders/images/tender_{id}
                    $path = $image->store("tenders/images/tender_{$tender->id}", 'public');

                    $tender->images()->create([
                        'image' => basename($path),
                    ]);
                }
            }

            // 4. Save attachments
            if ($request->hasFile('attachments')) {
                /** @var \Illuminate\Http\UploadedFile $attachment */
                foreach ($request->file('attachments') as $attachment) {
                    // Store on the 'public' disk under tenders/attachments/tender_{id}
                    $path = $attachment->store("tenders/attachments/tender_{$tender->id}", 'public');

                    $tender->attachments()->create([
                        'file_path' => basename($path),
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getClientMimeType(),
                        'file_size' => $attachment->getSize(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('customer.tenders.index')
                ->with('success', 'Tender created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to create tender: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display a specific tender.
     *
     * @param Tender $tender
     * @return \Illuminate\View\View
     */
    public function show(Tender $tender)
    {
        $this->authorize('view', $tender);
        $tender->load(['categories', 'images', 'attachments']);
        return view('customer.tenders.show', compact('tender'));
    }

    /**
     * Show the form for editing an existing tender.
     *
     * @param Tender $tender
     * @return \Illuminate\View\View
     */
    public function edit(Tender $tender)
    {
        $this->authorize('update', $tender);
        $categories = \App\Models\Category::all();
        return view('customer.tenders.edit', compact('tender', 'categories'));
    }

    /**
     * Update a tender, including new images and attachments.
     *
     * @param UpdateTenderRequest $request
     * @param Tender $tender
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTenderRequest $request, Tender $tender)
    {
        $this->authorize('update', $tender);

        DB::beginTransaction();

        try {
            // Update tender fields
            $tender->update([
                'title' => $request->title,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'expires_at' => $request->expires_at,
                'is_featured' => $request->has('is_featured'),
            ]);

            // Update categories
            $tender->categories()->sync($request->categories ?? []);

            // Handle new images
            if ($request->hasFile('images')) {
                /** @var \Illuminate\Http\UploadedFile $image */
                foreach ($request->file('images') as $image) {
                    $path = $image->store("tenders/images/tender_{$tender->id}", 'public');

                    $tender->images()->create([
                        'image' => basename($path),
                    ]);
                }
            }

            // Handle new attachments
            if ($request->hasFile('attachments')) {
                /** @var \Illuminate\Http\UploadedFile $attachment */
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store("tenders/attachments/tender_{$tender->id}", 'public');

                    $tender->attachments()->create([
                        'file_path' => basename($path),
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getClientMimeType(),
                        'file_size' => $attachment->getSize(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('customer.tenders.index')
                ->with('success', 'Tender updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to update tender: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Soft delete a tender.
     *
     * @param Tender $tender
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tender $tender)
    {
        $this->authorize('delete', $tender);

        $tender->delete();

        return redirect()->route('customer.tenders.index')
            ->with('success', 'Tender deleted successfully.');
    }
}