<?php

namespace App\Services\Setup;
use App\Models\RefCurrency;
use DB;

class CurrencyService
{
    public function store($request)
    {
        // Begin DB Transaction
        DB::beginTransaction();

        try {
          // Add Active status to Request
          $request['RX_IsActive'] = true;
          // Create Currency
          $currency = RefCurrency::create($request);
          // Commit Changes
          DB::commit(); 
          // Return Redirect
          return redirect('/setup/currency/'.$currency->id.'/edit')->with('sukses', 'Add Currency Success');
        } catch (\Throwable $th) {
          //Rollback Changes
          DB::rollback();
          // Return Redirect
          return redirect()->back()->with('gagal', $th->getMessage());
        }
    }

    public function update($request, RefCurrency $currency)
    {
        // Begin DB Transaction
        DB::beginTransaction();

        try {
          // Update Currency
          $currency->update($request);
          // Commit Changes
          DB::commit();
          // Return Redirect
          return redirect('/setup/currency/'.$currency->id.'/edit')->with('sukses', 'Edit Currency Success');
        } catch (\Throwable $th) {
          // Rollback Changes
          DB::rollback();
          // Return Redirect
          return redirect()->back()->with('gagal', $th->getMessage());
        }
        
    }
}
