
                <div class="row">
                    <!-- Basic Layout -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b> #1</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tanggal dikeluarkan</label>
                                            <div class="col-sm-8">
                                                <input required type="date" class="form-control" id="tanggal" name="tanggal" value="{{old('tanggal',isset($biaya) ? $biaya->tanggal : date('Y-m-d'))}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="kode">Nomor</label>
                                            <div class="col-sm-8">
                                                <input type="text" maxLength="30" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" id="nomor" name="nomor" value="{{old('nomor',isset($biaya) ? $biaya->nomor : '')}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Pejabat pembuat komitmen</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="pejabat_komitmen" id="pejabat_komitmen">
                                                    @foreach($pejabat_komitmen as $p)
                                                        <option value="{{$p->id}}">{{$p->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Nama pegawai yang diperintahkan</label>
                                            <div class="col-sm-8">
                                                <input type="text" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" id="pegawai_diperintah" name="pegawai_diperintah" value="{{old('pegawai_diperintah',isset($biaya) ? $biaya->pegawai_diperintah : '')}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">NIP</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="nip" name="nip" value="{{old('nip',isset($biaya) ? $biaya->nip : '')}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Pangkat dan Gol. Ruang Gaji</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="pangkat_golongan" id="pangkat_golongan">
                                                    @foreach($pangkat_golongan as $pg)
                                                        <option value="{{$pg->id}}">{{$pg->golongan != "" ? $pg->golongan.' - '.$pg->pangkat : $pg->pangkat}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jabatan / Instansi</label>
                                            <div class="col-sm-8">
                                                <input type="text" maxLength="50" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" id="jabatan_instansi" name="jabatan_instansi" value="{{old('jabatan_instansi',isset($biaya) ? $biaya->jabatan_instansi : '')}}" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Kelompok (jenis) jabatan</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="kelompok_jabatan" id="kelompok_jabatan">
                                                    @foreach($kelompok_jabatan as $kj)
                                                        <option value="{{$kj->id}}">{{$kj->kelompok.' - '.$kj->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b> #2</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Tingkat Perj. dinas</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="tingkat_perj_dinas" id="tingkat_perj_dinas">
                                                    <option {{isset($biaya) ? ($biaya->tingkat_perj_dinas == 'Tergolong Tingkat A' ? 'selected' : '') : ''}} value="Tergolong Tingkat A">Tergolong Tingkat A</option>
                                                    <option {{isset($biaya) ? ($biaya->tingkat_perj_dinas == 'Tergolong Tingkat B' ? 'selected' : '') : 'selected'}} value="Tergolong Tingkat B">Tergolong Tingkat B</option>
                                                    <option {{isset($biaya) ? ($biaya->tingkat_perj_dinas == 'Tergolong Tingkat C' ? 'selected' : '') : ''}} value="Tergolong Tingkat C">Tergolong Tingkat C</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Jenis Transportasi</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="transport_id" id="transport_id">
                                                    @foreach($transport as $t)
                                                        <option value="{{$t->id}}">{{$t->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Tempat Berangkat</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="kota_asal_id" id="kota_asal_id">
                                                    @foreach($kota as $kt)
                                                        <option value="{{$kt->id}}">{{$kt->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Ket. Keberangkatan</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="ket_keberangkatan" id="ket_keberangkatan" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Tanggal Keberangkatan</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="tanggal_berangkat" name="tanggal_berangkat" value="{{old('tanggal_berangkat',isset($biaya) ? $biaya->tanggal_berangkat : date('Y-m-d'))}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Tanggal Harus kembali</label>
                                            <div class="col-sm-8">
                                                <input  type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Lama perjalanan dinas</label>
                                            <div class="col-sm-8">
                                                <input  {{$action == 'store' ? 'required' : ''}} type="text" class="form-control" id="lama_perj_dinas" name="lama_perj_dinas" value="{{old('lama_perj_dinas',isset($biaya) ? $biaya->lama_perj_dinas : '3')}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Tempat tujuan</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="kota_tujuan_id" id="kota_tujuan_id">
                                                    @foreach($kota as $kt)
                                                        <option value="{{$kt->id}}">{{$kt->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Ket. ditujuan</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="ket_tujuan" id="ket_tujuan" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b> #3</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Status Perkawinan</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="status_perkawinan" id="status_perkawinan">
                                                        <option value="Bujangan">Bujangan</option>
                                                        <option value="Keluarga">Keluarga</option>
                                                        <option value="Anak 1">Anak 1</option>
                                                        <option value="Anak 2">Anak 2</option>
                                                        <option value="Anak 3 (+)">Anak 3 (+)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">maksud perjalanan dinas <br>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="1" name="maksud_check" id="maksud_ketuama">
                                                    <label class="form-check-label" for="ketuama"><small class="text-primary"> Ketua MA RI</small> </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="2" name="maksud_check" id="maksud_dirjen">
                                                    <label class="form-check-label" for="dirjen"><small class="text-primary"> Dirjen Badilum</small> </label>
                                                </div>
                                            </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="maksud_perj_dinas" id="maksud_perj_dinas" cols="30" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Jumlah pengikut</label>
                                            <div class="col-sm-8">
                                                <input  {{$action == 'store' ? 'required' : ''}} type="number" class="form-control" max="1" id="jumlah_pengikut" name="jumlah_pengikut"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Pembantu ikut</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="pembantu_ikut" id="pembantu_ikut">
                                                        <option value="0">Tidak ada/Tidak ikut</option>
                                                        <option value="1">Ya, ikut serta</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-form-label" for="password">Daftar keluarga yang ikut <br>
                                                <span><small class="text-primary">(AA,AK umur kurang dari dua tahun 67% dari tiket)</small></span>
                                            </label>
                                            <div class="col-sm-12">
                                                <div class="table-responsive row-table">
                                                    <table class="table" style="height:10rem;">
                                                        <thead>
                                                            <tr>
                                                                <th>Kena Biaya</th>
                                                                <th colspan="4" class="text-center">Daftar Nama Anggota Keluarga Yang Ikut Serta</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Perj. Dinas</th>
                                                                <th>No.</th>
                                                                <th style="width:280px">Nama</th>
                                                                <th>Thn/Tgl. Lahir</th>
                                                                <th style="width:220px">Umur</th>
                                                                <th style="width:300px">Keterangan</th>
                                                                <th>Tanggal dibuat</th>
                                                                <th>Nama pembuat</th>
                                                                <th>Tanggal diubah</th>
                                                                <th>Nama pengubah</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="item-keluarga">

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="11" class="text-end">
                                                                    <button title="Tambah Anggota Keluarga" type="button" class="kel_add btn btn-sm rounded-pill btn-icon btn-primary">
                                                                        <span class="tf-icons bx bx-plus"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b> #4</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Pembebanan Anggaran / Instansi</label>
                                            <div class="col-sm-8">
                                                <input  {{$action == 'store' ? 'required' : ''}} type="text" class="form-control" id="pembebanan_anggaran" name="pembebanan_anggaran" value="DIREKTORAT JENDERAL BADAN PERADILAN UMUM"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Mata Anggaran</label>
                                            <div class="col-sm-8">
                                                <input  {{$action == 'store' ? 'required' : ''}} type="text" maxLength="50" class="form-control" id="mata_anggaran" name="mata_anggaran"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Keterangan lain - lain</label>
                                            <div class="col-sm-8">
                                                <input  {{$action == 'store' ? 'required' : ''}} type="text" maxLength="50" class="form-control" id="ket_lain2" name="ket_lain2"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">Nama pejabat pembuat komitmen (PPK)</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="pejabat_komitmen" id="pejabat_komitmen_nama">
                                                    @foreach($pejabat_komitmen as $p)
                                                        <option data-nip="{{$p->nip}}" value="{{$p->id}}">{{$p->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="password">NIP pejabat pembuat komitmen (PPK)</label>
                                            <div class="col-sm-8">
                                                <input readonly type="text" class="form-control" id="pejabat_komitmen_nip"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>