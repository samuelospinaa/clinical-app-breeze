<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinicalHistoryRequest;
use App\Http\Requests\UpdateClinicalHistoryRequest;
use App\Models\ClinicalHistory;

class ClinicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClinicalHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClinicalHistory $clinicalHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClinicalHistory $clinicalHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClinicalHistoryRequest $request, ClinicalHistory $clinicalHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClinicalHistory $clinicalHistory)
    {
        //
    }
}
