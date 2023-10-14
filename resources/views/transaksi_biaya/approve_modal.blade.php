

<div class="modal fade" id="approve-modal" tabindex="-1"  tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Approve Biaya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="background-color:#f5f5f9">
        <form id="form-modal-approve" action="{{url('transaksi-biaya/approve')}}" method="post">
          @csrf
          <input type="hidden" name="id" id="id" value="{{$biaya->id}}">
            
          <div class="row">
            <div class="col-12">
              <!-- <h6 class="text-muted">Filled Tabs</h6> -->
              <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-spd" aria-controls="navs-spd" aria-selected="true" >
                      <i class="tf-icons bx bx-user"></i> Data Pegawai - SPD
                      <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"></span>
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-transport" aria-controls="navs-transport" aria-selected="false">
                      <i class="tf-icons bx bx-paper-plane"></i> Biaya Transportasi
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-muat" aria-controls="navs-muat" aria-selected="false">
                      <i class="tf-icons bx bx-car"></i> Biaya Muat Barang
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-uangh" aria-controls="navs-uangh" aria-selected="false">
                      <i class="tf-icons bx bx-money"></i> Uang Harian/Rampung
                    </button>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-spd" role="tabpanel">
                    @include('transaksi_biaya.approve_modal_spd')    
                  </div>

                  <div class="tab-pane fade" id="navs-transport" role="tabpanel">
                    @include('transaksi_biaya.approve_modal_transport')
                  </div>

                  <div class="tab-pane fade" id="navs-muat" role="tabpanel">      
                    @include('transaksi_biaya.approve_modal_muat')        
                  </div>

                  <div class="tab-pane fade" id="navs-uangh" role="tabpanel">   
                    @include('transaksi_biaya.approve_modal_uangh')        
                  </div>

                </div>

              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-approve-confirm">Approve</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
