@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
<div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                  Data Izin & Sakit
                </h2>
              </div>
              <!-- Page title actions -->
              </div>
            </div>
            </div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>tanggal</th>
                            <th>Nik</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Status Approve</th>
                            <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tanggalizin))  }}</td>
                            <td>{{ $d->nik }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->jabatan }}</td>
                            <td>{{ $d->status == "i" ? "izin": "sakit" }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>
                                @if ($d->status_approve==1)
                                <span class="badge bg-success">Approve</span>
                                @elseif($d->status_approve==2)
                                <span class="badge bg-danger">Reject</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($d->status_approve==0)
                                <a href="#" class="btn btn-sm btn-primary" id="approve" id_izinsakit="{{ $d->id }}">
                                    Edit
                                </a>
                                @else
                                <a href="/presensi/{{ $d->id }}/batalkanizinsakit" class="btn btn-sm btn-danger" >
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 10l4 4m0 -4l-4 4" /></svg>
                                Cancel
                                </a>
                                
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Status Approve</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/presensi/approveizinsakit" method="POST" id="" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <select name="status_approve" id="status_approve" class="form-select">
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                        </select>
                        <button class="btn btn-primary w-100">simpan</button>
                      </div>
                    </div>
                  </div>
            </form>
            </div>
        </div>
      </div>
    </div>

@endsection

@push('myscript')
<script>
    $(function(){

        $('#approve').click(function(e){
            e.preventDefault();
            var id_izinsakit = $(this).attr("id_izinsakit");
            $("#id_izinsakit_form").val(id_izinsakit);
            $("#modal-izinsakit").modal("show");
        });
    });
</script>
@endpush