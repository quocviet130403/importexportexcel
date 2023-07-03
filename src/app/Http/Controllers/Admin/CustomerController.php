<?php

namespace App\Http\Controllers\Admin;

use App\Events\ExportCustomerEvent;
use App\Events\ImportCustomerEvent;
use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            // 'street_address' => 'required',
            // 'city' => 'required',
            // 'state' => 'required',
            // 'country' => 'required',
            // 'organization_name' => 'required',
            // 'website' => 'required',
            // 'instagram' => 'required',
            // 'tiktok' => 'required',
            // 'twitter' => 'required',
            // 'youtube' => 'required',
            // 'description' => 'required',
            // 'notes' => 'required',
            'choose_one' => 'required'
        ]);
        $data = $request->all();
        if ($request->services) $data['services'] = implode(',', $request->services);
        if ($request->has_supported) $data['has_supported'] = implode(',', $request->has_supported);
        Customer::create($data);
        return redirect()->route('customer.index')->with(['level' => 'success', 'message' => 'Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.update', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $this->validate($request, [
                'last_name' => 'required',
                'first_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                // 'street_address' => 'required',
                // 'city' => 'required',
                // 'state' => 'required',
                // 'country' => 'required',
                // 'organization_name' => 'required',
                // 'website' => 'required',
                // 'instagram' => 'required',
                // 'tiktok' => 'required',
                // 'twitter' => 'required',
                // 'youtube' => 'required',
                // 'description' => 'required',
                // 'notes' => 'required',
                'choose_one' => 'required'
            ]);
            $data = $request->all();
            if ($request->services) $data['services'] = implode(',', $request->services);
            if ($request->has_supported) $data['has_supported'] = implode(',', $request->has_supported);
            $customer->update($data);
            return redirect()->back()->with(['level' => 'success', 'message' => 'Success!']);
        }
        return redirect()->back()->with(['level' => 'error', 'message' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            return redirect()->back()->with(['level' => 'success', 'message' => 'Success!']);
        }
        return redirect()->back()->with(['level' => 'error', 'message' => 'Error']);
    }

    public function import()
    {
        return view('admin.customers.import');
    }

    public function importStore(Request $request)
    {

        $this->validate($request, [
            'file_excel' => 'required|mimes:csv,xlsx,xls',
        ]);

        Log::info("CustomerController");
        $file = $request->file('file_excel');
        // $storedFile = $file->store('uploads');
        // event(new ImportCustomerEvent($storedFile));
        $import = Excel::import(new CustomersImport, $file);

        return redirect()->route('customer.index')->with(['level' => 'success', 'message' => 'Success!']);
    }

    public function export()
    {
        // event(new ExportCustomerEvent);
        // return redirect()->route('admin.customer.index')->with(['level' => 'success', 'message' => 'Success!']);
        return  Excel::download(new CustomersExport, 'data-' . Carbon::now()->timestamp . '.xlsx');
    }
}
