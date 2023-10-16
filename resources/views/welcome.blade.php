@extends('layout._template',['title' => 'DASHBOARD'])
@section('style')
<style>
    h3{
        text-align:center;
    }
    .summary{
        min-height: 170px;
    }
</style>
@endsection
@section('content')
<div class="col-lg-12 col-md-12 order-1">
    <div class="row">
        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-wallet"></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Biaya Approved</span>
                    <h3 class="card-title text-nowrap mb-1">{{isset($sumBiayaApproved) ? number_format($sumBiayaApproved->rampung_jumlah) : 0}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-wallet-alt"></i>
                        </div>
                    </div>
                    <span>Biaya Belum Approved</span>
                    <h3 class="card-title text-nowrap mb-1">{{isset($sumBiayaNotApproved) ? number_format($sumBiayaNotApproved->rampung_jumlah) : 0}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
