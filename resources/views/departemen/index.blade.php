@extends('layouts.admin.tabler')
@section('content')
<div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                  Departmen
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
                <div class="col-12">
                    <a href="#" class="btn btn-primary" id="tambahdepartemen">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Tambah
                    </a>
                </div>
              </div>
            </div>
<div class="col-12">
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>kode_dept</th>
                          <th>nama_dept</th>
                          <th class="w-1"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($departemen as $d)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td class="text-secondary">{{ $d->kode_dept }}</td>
                          <td class="text-secondary">{{ $d->Nama_dept }}</td>
                          <td>
                            <a href="#" class="edit" kode_dept="{{ $d->kode_dept }}">Edit</a>
                            <form action="/departemen/{{ $d->kode_dept }}/delete" method="POST">
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
                  </div>
                </div>
              </div>

              <div class="modal modal-blur fade" id="modal-tambahdata" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Departemen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" class="edit">
            <form action="/departemen/store" method="POST" id="formdepartemen" enctype="multipart/form-data">
              @csrf
            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                                </span>
                                <input type="text" name="kode_dept" id="kode_dept" value="" class="form-control" placeholder="Kode_dept">
                              </div>
              <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" name="nama_dept" id="nama_dept" value="" class="form-control" placeholder="Name_dept">
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
            <h5 class="modal-title">Edit Departemen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadeditform">
          </div>
        </div>
      </div>
    </div>
    

@endsection

@push('myscript')
<script>
    $(function(){
        $("#tambahdepartemen").click(function(){
            $("#modal-tambahdata").modal("show");
        });
        $("#formdepartemen").submit(function(){
          var kode_dept = $("#kode_dept").val();
          var nama_dept = $("#nama_dept").val();

           if(kode_dept == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#kode_dept").focus();
            });
            return false;
          }else if(nama_dept == ""){
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            }).then((result)=>{
              $("#nama_dept").focus();
            });
            return false;
          }
        });
        $(".edit").click(function(){
            var kode_dept = $(this).attr('kode_dept');
            $.ajax({
              type : 'POST'
            , url: '/departemen/edit'
            ,cache :false
            , data: {
                _token: "{{ csrf_token() }}"
                , kode_dept: kode_dept
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
        
    });
</script>
@endpush