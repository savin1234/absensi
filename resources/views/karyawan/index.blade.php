@extends('layouts.admin.tabler')
@section('content')
<div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                  Data Karyawan
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
                <div class="col-12">
                    <a href="#" class="btn btn-primary" id="tambahkaryawan">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Tambah
                    </a>
                </div>
              </div>
            </div>
<div class="col-12">
  <form action="/karyawan" method="GET">
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <input type="text" name="nik" class="form-control" value="{{ Request('nik') }}" placeholder="NIK">
        </div>
        <div class="row">
        <div class="col-8">
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
            </button>
          </div>
        </div>
        </div>
      </div>
    </div>
  </form>
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIK</th>
                          <th>Nama</th>
                          <th>Jabatan</th>
                          <th>Telepon</th>
                          <th>Departemen</th>
                          <th class="w-1"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($karyawan as $d)
                        <tr>
                          <td>{{ $loop->iteration + $karyawan->firstItem() -1 }}</td>
                          <td class="text-secondary">{{ $d->nik }}</td>
                          <td class="text-secondary">{{ $d->nama }}</td>
                          <td class="text-secondary">{{ $d->jabatan }}</td>
                          <td class="text-secondary">{{ $d->telepon }}</td>
                          <td class="text-secondary">{{ $d->kode_dept }}</td>
                          <td>
                            <a href="#" class="edit" nik="{{ $d->nik }}">Edit</a>
                            <form action="/karyawan/{{ $d->nik }}/delete" method="POST">
                            @csrf
                            <a class="btn btn-danger btn-sm delete-confirm">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </a>
                          </form>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                  </div>
                </div>
              </div>

              <div class="modal modal-blur fade" id="modal-tambahdata" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" class="edit">
            <form action="/karyawan/store" method="POST" id="formkaryawan" enctype="multipart/form-data">
              @csrf
            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                                </span>
                                <input type="text" name="nik" id="nik" value="" class="form-control" placeholder="NIK">
                              </div>
              <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" name="nama" id="nama" value="" class="form-control" placeholder="Name">
                              </div>
                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-badge"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.486 3.143l-4.486 2.69l-4.486 -2.69a1 1 0 0 0 -1.514 .857v13a1 1 0 0 0 .486 .857l5 3a1 1 0 0 0 1.028 0l5 -3a1 1 0 0 0 .486 -.857v-13a1 1 0 0 0 -1.514 -.857z" /></svg>
                                </span>
                                <input type="text" name="jabatan" id="jabatan" value="" class="form-control" placeholder="Jabatan">
                              </div>
                  <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <input type="text" name="telepon" id="telepon" value="" class="form-control" placeholder="Telepon">
                              </div>
                    <div class="row">
                      <div class="col">
                        <select name="kode_dept" id="kode_dept" class="form-select">
                          <option value="">Departemen</option>
                          @foreach ($karyawan as $d)
                          <option {{ Request('kode_dept')==$d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">
                        {{ $d->Nama_dept }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <button class="btn btn-primary w-100">simpan</button>
                      </div>
                    </div>
                  </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-blur fade" id="modal-editdata" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadeditform">

          </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('myscript')
<script>
    $(function(){
        $("#tambahkaryawan").click(function(){
            $("#modal-tambahdata").modal("show");
        });

        $(".edit").click(function(){
            var nik = $(this).attr('nik');
            $.ajax({
              type : 'POST'
            , url: '/karyawan/edit'
            ,cache :false
            , data: {
                _token: "{{ csrf_token() }}"
                , nik: nik
            }
            , success: function(respond){
              $("#loadeditform").html(respond);
            }
            });
            $("#modal-editdata").modal("show");
        });

        $(".delete-confirm").click(function(e){
          var form = $(this).closest('form');
          Swal.fire({
              title: "Apakah anda ingin menghapus data ini??"
              , showCancelButton: true
              , confirmButtonText: 'Delete'
            }).then((result)=>{
              if (result.isConfirmed){
                form.submit();
                swal.fire('deleted','','success')
              }
            })
        });

        
        $("#formkaryawan").submit(function(){
          var nik = $("#nik").val();
          var nama = $("#nama").val();
          var jabatan = $("#jabatan").val();
          var telepon = $("#telepon").val();
          var kode_dept = $("#kode_dept").val();

          if(nik == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#nik").focus();
            });
            return false;
          }else if(nama == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#nama").focus();
            });
            return false;
          }else if(jabatan == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#jabatan").focus();
            });
            return false;
          }else if(telepon == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#telepon").focus();
            });
            return false;
          }else if(kode_dept == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#kode_dept").focus();
            });
            return false;
          }
        });
    });
</script>
@endpush