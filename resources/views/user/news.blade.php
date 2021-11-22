<x-app-layout>
    <x-slot name="header">
        <div class="col-4 mb-4">
            <h2 class="h4 font-weight-bold ms-3">
            {{ __('Welcome!') }} <span class="ms-2">{{Auth::user()->fname}} {{Auth::user()->lname}}</span> 
            </h2>
        </div>
    </x-slot>

    <div class="row">
        <dv class="card col-6 m-auto fw-bold text-center bg-info py-3 my-5">
            This page is still under construction.
        </dv>
    </div>
                     
    <x-darkFooter></x-darkFooter>
</x-app-layout>